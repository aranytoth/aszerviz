<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $model = Category::orderBy('id', 'desc')->paginate(20);
        return view('admin.category.index', compact('model'));
    }

    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $params = $request->all();

        $category = new Category();
        $category->name = $params['name'];
        $category->slug = !empty($params['slug']) ? Str::slug($params['slug']) : Str::slug($category->name);
        $category->parent_id = $params['parent_id'];

        if($category->save()){
            return redirect(route('categories.index'));
        }
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id','<>', $category->id)->orderBy('id', 'desc')->get();
        return view('admin.category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $params = $request->all();
        $category->fill($params);
        if($category->save()){
            return redirect(route('categories.edit', ['category' => $category->id]));
        }
    }

    public function view()
    {

    }

    public function destroy()
    {

    }
}
