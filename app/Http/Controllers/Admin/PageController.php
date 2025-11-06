<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PageType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::where('type', PageType::Page)->get();
        return view('admin.page.index', compact('pages'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.page.create', compact('categories'));
    }

    public function store(PageRequest $request)
    {
        $params = $request->all();
        $page = new Page();
        $page->fill($params['Page']);
        $page->type = PageType::Page->value;
        $page->slug = Str::slug($params['Page']['title']);

        if($page->save()){
            $pageCategory = new PageCategory();
            $pageCategory->category_id = $params['PageCategory'];
            if($page->pageCategory()->save($pageCategory)){
                return redirect(route('pages.index'));
            }
        } else {
            dd('hiba');
        }

        
    }

    public function edit(Page $page)
    {
        $categories = Category::all();
        return view('admin.page.edit', compact('page', 'categories'));
    }

     public function update(Request $request, Page $page)
    {
        $params = $request->all();
        
        
        $page->fill($params['Page']);
       
        if($page->save()){
            $page->pageCategory->category_id = $params['PageCategory'];
            $page->pageCategory->save();

            return redirect(route('pages.index'));

        }
    }

    public function view()
    {
        return view('admin.page.view');
    }

    public function delete()
    {
        return view('admin.page.delete');
    }

    

   
}
