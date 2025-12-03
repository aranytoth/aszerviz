<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function index()
    {
        return view('admin.settings.index');
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request)
    {

    }
}
