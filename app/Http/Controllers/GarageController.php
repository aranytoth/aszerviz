<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class GarageController extends Controller
{
    public function index()
    {
        $garages = Garage::orderBy('created_at', 'DESC')->paginate();
        return view('garage.index', compact('garages'));
    }

    public function create()
    {
        $users = User::role(User::ROLE_ADMIN)->get();
        return view('garage.create', compact('users'));
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $garage = new Garage();
        $garage->fill($params);
        $garage->company_id = Auth::user()->company->id;
        
        if($garage->save()){
            return redirect(route('garage.index'));
        } else {
            return redirect()->back();
        }
    }

    public function edit(Garage $garage)
    {
        return view('garage.edit', compact('garage'));
    }

    public function update(Request $request, Garage $garage)
    {
        $params = $request->all();
        $garage->fill($params);
        if(empty($garage->prefix)){
          //  $garage->prefix = $garage->createPrefix();
        }
        if($garage->save()){
            return redirect(route('garage.index'));
        } else {
            return redirect()->back();
        }
    }

    public function delete()
    {

    }

    
}
