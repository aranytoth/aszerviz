@extends('layouts.admin')

@section('js')
<script src="{{ asset('static/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('static/libs/tinymce/gallery.js') }}"></script>
<script src="{{ asset('static/libs/tinymce/columns.js') }}"></script>
<script>
    tinymce.init({
        selector: '#editor',
        license_key: 'gpl',
        height: 600,
        menubar: false,
        editable_class: 'mceEditable',
        plugins: [
          'advlist', 'autolink', 'lists', 'table', 'link', 'image', 'charmap', 'preview',
          'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
          'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount', 'gallery', 'twocolumn'
        ],
        
        toolbar: 'undo redo | blocks | bold italic backcolor | ' +
          'alignleft aligncenter alignright alignjustify | ' +
          'bullist numlist outdent indent table gallery twocolumn | removeformat | help',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        
    });
</script>
@endsection

@section('content')
@if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif
<form method="post" action="{{route('pages.update', ['page' => $page->id])}}">
    @method('PUT')
    @csrf
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h4 class="mb-4">Oldal szerkesztése</h4>
                    </div>
                    <div class="lang-selector">
                        <ul>
                            @foreach (config('app.available_locales', ['hu', 'en']) as $key => $lang)
                                <li><label for="lang-{{$lang}}" class="{{$key == 0 ? 'selected' : ''}}">{{strtoupper($lang)}}</label></li>
                            @endforeach
                        </ul>
                    </div>
                    @foreach (config('app.available_locales', ['hu', 'en']) as $key => $lang)
                    <input type="radio" name="lang-selector" class="lang-selector-input" id="lang-{{$lang}}" {{$key == 0 ? 'checked' : ''}}>
                    <div class="lang-block">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="Page[title][{{$lang}}]" placeholder="Cím hozzáadása" value="{{old('Page.title.'.$lang) ?? $page->getTranslation('title', $lang)}}">
                                    @error('Page.title')
                                        <div class="invalid-feedback d-block">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea placeholder="Lead" name="Page[lead][{{$lang}}]" class="form-control">{{old('Page.lead.'.$lang) ?? $page->getTranslation('lead', $lang)}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea name="Page[content][{{$lang}}]" id="editor">{{old('Page.content'.$lang) ?? $page->getTranslation('content', $lang)}}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card">
            <div class="card-header">
                Közzététel
            </div>
            <div class="card-body">
                ssdf
            </div>
            <div class="card-footer text-muted d-flex justify-content-between">
                @if ($page->status !== App\Enums\PageStatus::Visible)
                    <button type="submit" name="Page[status]" value="10" class="btn btn-sm btn-success">Közzététel</button>
                    <button type="submit" name="Page[status]" value="1" class="btn btn-sm">Piszkozat mentése</button>
                @else
                    <button type="submit" name="Page[status]" value="10" class="btn btn-sm btn-success">Mentés</button>
                    <button type="submit" name="Page[status]" value="1" class="btn btn-sm">Átállítás vázlatra</button>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Kategória
            </div>
            <div class="card-body">

                <select name="PageCategory" class="form-select">
                    <option value="0">Nincs kategória</option>
                    @foreach ($categories as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
</form>
@endsection