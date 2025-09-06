<?php

namespace App\Http\Controllers;

use App\Mail\Offer;
use App\Models\Client;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Worksheet;
use App\Models\WorksheetImage;
use App\Models\WorksheetItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;

class WorksheetController extends Controller
{
    public function index(Request $request) : View
    {
        $params = $request->all();
        $statuses = Worksheet::$statuses;
        $users = User::role('mechanic')->get();
        $model = Worksheet::orderBy('created_at', 'DESC')
        ->when(isset($params['worksheet']), function($query) use ($params){
            $query->where('worksheet.name', 'like', '%'.$params['worksheet'].'%');
        });
        
        $model = $model->paginate(20);
        return view('worksheet.index', compact('model', 'statuses', 'users', 'params'));
    }

    public function create() : View
    {
        $mechanics = User::role('mechanic')->get();
        return view('worksheet.create', compact('mechanics'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        
        // TODO validáció

        // Ügyfél létrehozása

        if(!isset($params['Client']['id'])){
            $client = new Client();
            $client->fill($params['Client']);
            if($client->save()){

            } else {
                dd('Ügyfél probléma');
            }

        } else {
            $client = Client::where('id', $params['Client']['id'])->first();
        }

        // Gépjármű létrehozása
        if(!isset($params['Vehicle']['id'])){
            $vehicle = new Vehicle();
            $vehicle->fill($params['Vehicle']);
            $vehicle->license_plate = Str::upper($vehicle->license_plate);
            if($vehicle->save()) {
                
            } else {
                dd($vehicle->getErrors());
            }
        } else {
            $cient = Vehicle::where('id', $params['Vehicle']['id'])->first();
        }
        
        // Munkalap létrehozása
        $worksheet = new Worksheet();
        $worksheet->fill($params['WorkSheet']);
        $worksheet->garage_id = isset(Auth::user()->garage_id) ? Auth::user()->garage_id : Auth::user()->company->garages[0]->id;
        $worksheet->client_id = $client->id;
        $worksheet->vehicle_id = $vehicle->id;
        $worksheet->station_id = 1; // ha kell szerelőállás, beüzemeljük
        $worksheet->createWorkSheetId();

        if($worksheet->save()){
            return redirect(route('worksheet.edit', ['worksheet' => $worksheet->id]));
        }
    }

    public function edit(Worksheet $worksheet) : View
    {
        $mechanics = User::role('mechanic')->get();
        $vehicle = !empty($worksheet->vehicle) ? $worksheet->vehicle : new Vehicle();
        $client = !empty($worksheet->client) ? $worksheet->client : new Client();
        return view('worksheet.edit', compact('worksheet','mechanics', 'vehicle', 'client'));
    }

    public function update(Request $request, Worksheet $worksheet)
    {
        $params = $request->all();
        $this->handleWorksheetImages($worksheet, $request['WorksheetImage'] ?? []);
        $this->handleWorksheetItems($worksheet, $request['WorksheetItem'] ?? []);
        //dd(preg_replace('/[^0-9]/', '', $params['WorkSheet']['calc_price'])); 
        $worksheet->fill($params['WorkSheet']);
        $worksheet->save();

        $worksheet->client->fill($params['Client']);
        $worksheet->client->save();

        $worksheet->vehicle->fill($params['Vehicle']);
        $worksheet->vehicle->save();
        
        // dd($params);
        return redirect()->back();
    }

    public function view(Worksheet $worksheet)
    {
        return view('worksheet.view', compact('worksheet'));
    }

    public function createPDF(Worksheet $worksheet)
    {
        Storage::disk('public')->makeDirectory('/pdf');

        $pdf = Pdf::loadView('pdf.worksheet', ['worksheet' => $worksheet]);
        return $pdf->stream('invoice.pdf');

    }

    public function sendOffer(Request $request, Worksheet $worksheet) : JsonResponse
    {
        $params = $request->all();
        $email = isset($params['email']) && !empty($params['email']) ? $params['email'] : $worksheet->client->email;
        $pdf = Pdf::loadView('pdf.worksheet', ['worksheet' => $worksheet]);
        $pdf->save(Storage::disk('public')->path('pdf/'.$worksheet->worksheet_id.'.pdf'));
        //Mail::to($worksheet->client->email)->send(new Offer($worksheet));
        Mail::to($email)->send(new Offer($worksheet));
        $history = $worksheet->history;
        $history[] = [Carbon::now()->format('Y-m-d H:i:s') => ['Ajánlat kiküldve', Auth::id()]];
        $worksheet->history = $history;
        $worksheet->save();
        return response()->json(['success' => true], 200);
    }

    public function setStatus(Request $request, Worksheet $worksheet) : JsonResponse
    {
        $params = $request->all();
        if(isset($params['status'])) {
            $worksheet->status = $params['status'];
            $history = $worksheet->history;
            $history[] = [Carbon::now()->format('Y-m-d H:i:s') => ['Státusz megváltozott: '.Worksheet::$statuses[$params['status']], Auth::id()]];
            $worksheet->history = $history;
            $worksheet->save();
            return response()->json(['success' => true], 200);
        } else {
            return response()->json(['success' => false], 400);
        }
    }

    public function createInvoice(Worksheet $worksheet)
    {

    }

    private function handleWorksheetImages(Worksheet $worksheet, array $items)
    {
        foreach($worksheet->images as $item){
            if(isset($items['current'][$item->id])){
                $item->fill($items['current'][$item->id]);
                $item->save();
            } else {
                $item->delete();
            }
        }
        if(isset($items['new'])){
            foreach($items['new']['image'] as $key => $image){
                $newItem = new WorksheetImage();
                $newItem->worksheet_id = $worksheet->id;
                $newItem->note = $items['new']['note'][$key];
                $newItem->image = $image;
                $newItem->storeWorksheetImage();
                $newItem->save();
            }
        }
        
    }

    private function handleWorksheetItems(Worksheet $worksheet, array $items)
    {

        foreach($worksheet->items as $item){
            if(isset($items['current'][$item->id])){
                $item->fill($items['current'][$item->id]);
                if(empty($item->item_num)){
                    $item->item_num = '--';
                }
                if(!$item->is_work){
                    $item->worker_user_id = null;
                }
                $item->save();
            } else {
                $item->delete();
            }
        }

        if(isset($items['new'])){
            $newItems = $items['new'];
            foreach($newItems as $item){
                
                $wsItem = new WorksheetItem();
                $wsItem->worksheet_id = $worksheet->id;
                $wsItem->fill($item);
                if(empty($wsItem->item_num)){
                    $wsItem->item_num = '--';
                }
                $wsItem->quantity = str_replace(',', '.', $wsItem->quantity);
            
                $wsItem->save();
            }
        }
        
    }
}
