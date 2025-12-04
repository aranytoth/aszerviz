<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
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
        $params = $request->all();
        
        foreach($params as $key => $value){
            if (!in_array($key, Settings::$defaultSettings) || empty($value)) {
                continue;
        }
    
            Settings::updateOrCreate(
                ['name' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Beálítások módosítva');
    }
}
