<?php

namespace App\Http\Controllers;

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
        return view('vehicle.view', compact('vehicle'));
    }
}
