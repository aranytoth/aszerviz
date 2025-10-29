<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PageType;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $pages = Page::where('type', PageType::Post)->get();
        return view('admin.post.index', compact('pages'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit(Page $post)
    {

    }

    public function update(Request $request, Page $post)
    {

    }

    public function view(Page $post)
    {

    }

    public function delete()
    {

    }
}
