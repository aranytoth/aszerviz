<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::orderBy('created_at', 'DESC')->paginate();

        return view('vehicle.index', compact('vehicles'));
    }

    public function view(Vehicle $vehicle)
    {
        $vehicle->load('worksheets');
        return view('vehicle.view', compact('vehicle'));
    }

    public function search(Request $request)
    {
        $params = $request->all();
        if($params['term']){
            $model = Vehicle::where('license_plate', 'like', '%'.$params['term'].'%')->get();
            
            foreach($model as $key => $vehicle){
                $model[$key]->text = $vehicle->license_plate;
            }
            $response = [
                'results' => $model
            ];

            return response()->json($response);
        }
    }
}
