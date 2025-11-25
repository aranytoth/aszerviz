<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $model = Tag::orderBy('name', 'desc')->get();
        return view('admin.tags.index', compact('model'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $params = $request->all();
        $tag = new Tag();
        $tag->fill($params);
        $tag->slug = !empty($params['slug']) ? Str::slug($params['slug']) : Str::slug($params['name']['hu']);

        if($tag->save()){
            return redirect(route('tags.index'));
        }
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function view()
    {

    }

    public function destroy()
    {

    }

    public function search(Request $request)
    {
        $params = $request->all();

        if(isset($params['q']) && strlen($params['q']) > 2){
            $model = Tag::where('name', 'like', '%'.$params['q'].'%')->get();

            foreach($model as $key => $tag){
                $model[$key]->text = $tag->name;
            }
            $response = [
                'results' => $model
            ];

            return response()->json($response);
        }
    }
}
