<?php

namespace App\Http\Controllers;

use App\Models\Garage;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class UserController extends Controller
{

    use ResetsPasswords;


    public function index() : View
    {
        $model = User::all();
        $roles = User::$roles;

        return view('users.index', compact('model', 'roles'));
    }

    public function create()
    {
        $roles = User::$roles;
        $garages = Garage::where('company_id', Auth::user()->company->id)->get();

        return view('users.create', compact('roles', 'garages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $params = $request->all();
        $model = new User();
        $model->fill($params);
        $model->password = Hash::make(rand(1000, 100000));

        if($model->save()){
            $model->assignRole($params['role']);
            $status = Password::sendResetLink(
                $request->only('email')
            );
            return redirect(route('users.index'))->with('create', 'success');
        } else {
            return redirect()->back();
        }
    }

    public function edit(User $user) : View
    {
        $roles = User::$roles;
        $statuses = User::$status;

        return view('users.edit', compact('user','roles', 'statuses'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $params = $request->all();
        $user->fill($params);
        if($user->save()){
            $user->syncRoles([$params['role']]);
            return redirect(route('users.index'))->with('save', 'success');
        } else {
            return redirect()->back();
        }
        
    }

    public function delete()
    {

    }
}
