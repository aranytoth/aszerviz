<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientsController extends Controller
{
    public function index() : View
    {
        $clients = Client::orderBy('created_at', 'DESC')->paginate();

        return view('client.index', compact('clients'));
    }

    public function view(Client $client)
    {
        return view('client.view', compact('client'));
    }

    public function search(Request $request)
    {
        $params = $request->all();
        if($params['term']){
            $model = Client::where('name', 'like', '%'.$params['term'].'%')->orWhere('email', 'like', '%'.$params['term'].'%')->get();
            
            foreach($model as $key => $client){
                $model[$key]->text = $client->name;
            }
            $response = [
                'results' => $model
            ];

            return response()->json($response);
        }
    }
}
