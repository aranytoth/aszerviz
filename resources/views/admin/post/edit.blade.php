@extends('layouts.admin')

@section('js')
<script src="{{ asset('static/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('static/libs/tinymce/gallery.js') }}"></script>
<script src="{{ asset('static/libs/tinymce/columns.js') }}"></script>
<script src="{{asset('static/libs/select2/js/select2.full.min.js')}}"></script>
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
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

$(function(){
    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    var prevFile;
    $("span#images-con").dropzone({
            url: "{{route('media.upload')}}",
            paramName: "image",
            previewsContainer: ".images-previews",
            clickable: '.add-image-btn',
            acceptedFiles: 'image/*,audio/*,video/*',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(file, response) {
                prevFile = file;
                $(file.previewElement).find('img').attr('src', response.thumb_url);
                $(file.previewElement).find('.dz-progress').hide();
                $(file.previewElement).find('input.imagename-input').val(response.url);
    
            },
            uploadprogress: function(file, progress, bytesSent){
            },
            sending: function(){
            //this.element.querySelector('.dz-preview').remove();
            },
            previewTemplate: `<div class="dz-preview dz-file-preview">
            <div class="dz-details">
                <div class="dz-image"><img data-dz-thumbnail /></div>
                <div class="dz-progress">
                    <div class="spinner-border text-primary m-1" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <input type="hidden" name="Page[lead_image]" class="imagename-input" value=""><hr />
            
            </div>`
    });
});
</script>
@endsection

@section('content')

<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif
<form method="post" action="{{route('post.update', ['page' => $page->id])}}">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
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
                                        <textarea placeholder="Lead" name="Page[lead][{{$lang}}]" class="form-control">{{old('Page.lead'.$lang) ?? $page->getTranslation('lead', $lang)}}</textarea>
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
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Címkék</label>
                            
                            <select class="form-select" id="search-tag" name="Tags[id][]" multiple placeholder="Címkék">
                                
                                @foreach ($page->pageTags as $pageTag)
                                    <option selected value="{{$pageTag->tag_id}}">{{$pageTag->tag->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
           
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Közzététel
                </div>
                <div class="card-body">
                    ssdf
                </div>
                <div class="card-footer text-muted d-flex justify-content-between">
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
            </div>

            <div class="card">
                <div class="card-header">
                    Lead kép
                </div>
                <div class="card-body">
                    <span id="images-con">
                            <div class="images-previews">
                                @if (!empty($page->lead_image))
                                    <img src="{{$page->lead_image}}" />
                                @endif
                            </div>
                            
                    </span>
                    <span class="add-image-btn"><i class="dripicons-camera"></i></span>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
