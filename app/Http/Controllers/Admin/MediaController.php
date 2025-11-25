<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{

    public function index()
    {
        $media = $this->getMedia();
        return view('admin.media.index', compact('media'));
    }

    public function show(Media $media)
    {
        return view('admin.media.show', compact('media'));
    }

    public function update(Request $request, Media $media)
    {
        $params = $request->only('name');
        $media->name = $params['name'];
        $media->save();
        return redirect(route('media.index'));
    }

    public function edit(Media $media)
    {
        return view('admin.media.edit', compact('media'));
    }

    public function images(Request $request)
    {
        $params = $request->only('page', 'size');

        // Lekérjük az összes média elemet, csökkenő sorrendben (legújabb elöl)
        // 20-as lapozással
        $allMedia = $this->getMedia($params['size'] ?? 20, true);

        return $allMedia;

    }

    public function store(Request $request)
    {
        // 1. Validáció
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // Max 5MB
        ]);

       $model = Auth::user();
        // 3. Kép mentése a Spatie segítségével
        // A 'toMediaCollection' automatikusan kezeli a fájlrendszert és az adatbázist
        $media = $model->addMedia($request->file('image'))
                       ->toMediaCollection($request->input('collection', 'default'));



        return response()->json([
            'message' => 'Kép sikeresen feltöltve',
            'url' => $media->getUrl(),
            'thumb_url' => $media->getUrl('thumb'), // Ha definiáltál konverziót
            'id' => $media->id
        ]);
    }

    public function destroy($mediaId)
    {
        // Törlés logika (Spatie Media modelt használva)
        $media = \Spatie\MediaLibrary\MediaCollections\Models\Media::findOrFail($mediaId);
        $media->delete();

        return response()->json(['message' => 'Kép törölve']);
    }

    private function getModelInstance($type, $id)
    {
        // Mapeld a stringeket a valós osztályokhoz a biztonság érdekében
        $mapping = [
            'post' => Page::class,
            //'product' => Product::class,
        ];

        if (!array_key_exists($type, $mapping)) {
            return null;
        }

        return $mapping[$type]::find($id);
    }

    private function getMedia($paginate = 20, $json = false)
    {
       $media = Media::query()
            ->where('mime_type', 'LIKE', 'image/%') 
            ->where('collection_name', '!=', 'avatar')
            ->latest()
            ->paginate($paginate);

            if($json){
                return MediaResource::collection($media);
            } else {
                return $media;
            }
        
    }
}
