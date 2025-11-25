@extends('layouts.admin')

@section('js')
<script src="{{ asset('static/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('static/libs/tinymce/gallery.js') }}"></script>
<script src="{{ asset('static/libs/tinymce/columns.js') }}"></script>
<script src="{{asset('static/libs/select2/js/select2.full.min.js')}}"></script>
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
    $('#search-tag').select2({
        tags: true,
        minimumInputLength: 2,
        ajax: {
            url: '{{route('api.search.tag')}}',
            dataType: 'json'
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
    });

    $('#search-tag').on('select2:select', function (e) {
    var data = e.params.data;
    if(data.id) {
        
    }
    //const s = data.id;
    //$('#search-vehicle').after('<input type="hidden" name="Tag[id]" value="'+s+'">');
        
    
});
</script>
@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif
<form method="post" action="{{route('post.store')}}">
    @csrf
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6">
                            <h4 class="mb-4">Új oldal</h4>
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
                                        <input type="text" class="form-control" name="Page[title][{{$lang}}]" placeholder="Cím hozzáadása" value="{{old('Page.title.'.$lang)}}">
                                        @error('Page.title')
                                            <div class="invalid-feedback d-block">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea placeholder="Lead" name="Page[lead][{{$lang}}]" class="form-control">{{old('Page.lead'.$lang)}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea name="Page[content][{{$lang}}]" id="editor">{{old('Page.content'.$lang)}}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Címkék</label>
                        <select class="form-select" id="search-tag" name="Tags[id][]" multiple placeholder="Címkék"></select>
                        </div>
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
                    <button type="submit" name="Page[status]" value="2" class="btn btn-sm btn-success">Közzététel</button><button type="submit" name="Page[status]" value="1" class="btn btn-sm">Piszkozat mentése</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Kategória
                </div>
                <div class="card-body">
                    ssdf
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
