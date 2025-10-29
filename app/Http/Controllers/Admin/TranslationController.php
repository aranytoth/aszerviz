<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use App\Models\TranslationValue;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function __construct(
        protected TranslationService $translationService
    ) {}
    
    public function index()
    {
        $locales = config('app.available_locales', ['hu', 'en']);
        $groups = $this->translationService->getAllGroups();
        $model = Translation::orderBy('id', 'DESC')->paginate(20);
        
        return view('admin.translations.index', compact('locales', 'groups', 'model'));
    }

    public function create()
    {

        $locales = config('app.available_locales', ['hu', 'en']);
        $locale = app()->getLocale();
        $groups = $this->translationService->getAllGroups();

        return view('admin.translations.create', compact('locales', 'groups', 'locale'));

    }

    public function store(Request $request)
    {
        $params = $request->all();


        if(isset($params['Translation'])){
            $translation = new Translation();
            $translation->key = $params['Translation']['key'];
            $translation->group = $params['Translation']['group'];

            if($translation->save()){
                foreach($params['TranslationValues'] as $key => $value){
                    $trValue = new TranslationValue();
                    $trValue->translation_id = $translation->id;
                    $trValue->lang = $key;
                    $trValue->value = $value;
                    $trValue->save();
                }
                
                return redirect(route('translations.index'));
            }
        }
    }
    
    public function edit(Translation $translation)
    {
        $locales = config('app.available_locales', ['hu', 'en']);
        $groups = $this->translationService->getAllGroups();
        $locale = app()->getLocale();
        return view('admin.translations.edit', compact('translation', 'locale', 'locales', 'groups'));
    }
    
    public function update(Request $request, string $locale, string $group = 'common')
    {
        $validated = $request->validate([
            'translations' => 'required|array',
            'translations.*' => 'nullable|string|max:1000'
        ]);
        
        $this->translationService->updateTranslations(
            $validated['translations'],
            $locale,
            $group
        );
        
        return back()->with('success', "Fordítások frissítve: {$group}");
    }
    
    public function clearCache()
    {
        $this->translationService->clearCache();
        return back()->with('success', 'Cache törölve!');
    }
}