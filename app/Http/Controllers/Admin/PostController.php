<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Models\PageTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $pages = Page::where('type', PageType::Post)->get();
        return view('admin.post.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(PageRequest $request)
    {
        $params = $request->all();

        $page = new Page();
        $page->fill($params['Page']);
        $page->type = PageType::Post->value;
        $page->slug = Str::slug($params['Page']['title']['hu']);
        
        if($page->save()){
            $page->updateTags($params['Tags']['id']);
        }

        return redirect(route('post.index')); 
    }

    public function edit(Page $page)
    {
        
        return view('admin.post.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page)
    {
        
        $params = $request->all();

        $page->fill($params['Page']);

        if($page->save()){
            $page->updateTags($params['Tags']['id']);
        }

        return redirect(route('post.index'));
    }

    public function view(Page $page)
    {

    }

    public function delete()
    {

    }
}
