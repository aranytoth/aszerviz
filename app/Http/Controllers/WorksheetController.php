<?php

namespace App\Http\Controllers;

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

class WorksheetController extends Controller
{
    public function index() : View
    {
        $model = Worksheet::orderBy('created_at', 'DESC')->paginate(20);
        return view('worksheet.index');
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
        $worksheet->garage_id = Auth::user()->garage_id;
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
        $this->handleWorksheetImages($worksheet, $request['WorksheetImage']);
        $this->handleWorksheetItems($worksheet, $request['WorksheetItem']);
        //dd(preg_replace('/[^0-9]/', '', $params['WorkSheet']['calc_price']));
        if(!empty($params['WorkSheet']['calc_price'])){
            $params['WorkSheet']['calc_price'] = preg_replace('/[^0-9]/', '', $params['WorkSheet']['calc_price']);
        }
        $worksheet->fill($params['WorkSheet']);
        $worksheet->save();
        
        // dd($params);
        return redirect()->back();
    }

    public function createPDF(Worksheet $worksheet)
    {
        $pdf = Pdf::loadView('pdf.worksheet', ['worksheet' => $worksheet]);
        return $pdf->stream('invoice.pdf');

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
                $wsItem->quantity = str_replace(',', '.', $wsItem->quantity);
            
                $wsItem->save();
            }
        }
        
    }
}
