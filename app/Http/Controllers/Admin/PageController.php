<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('type', PageType::Page)->get();
        return view('admin.page.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.page.create');
    }

    public function store(PageRequest $request)
    {
        $params = $request->all();
        dd($params);
        
    }

    public function edit()
    {
        return view('admin.page.edit');
    }

    public function view()
    {
        return view('admin.page.view');
    }

    public function delete()
    {
        return view('admin.page.delete');
    }

    

    public function update(Request $request)
    {
        // Handle updating an existing page
    }
}
