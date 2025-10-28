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
<form method="post" action="{{route('pages.store')}}">
    @csrf
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h4 class="mb-4">Új oldal</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="title" placeholder="Cím hozzáadása" value="{{old('title')}}">
                                @error('title')
                                    <div class="invalid-feedback d-block">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <textarea placeholder="Lead" name="lead" class="form-control">{{old('lead')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="editor">{{old('content')}}</div>
                        </div>
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
                <button type="submit" name="status" value="2" class="btn btn-sm btn-success">Közzététel</button><button type="submit" name="status" value="1" class="btn btn-sm">Piszkozat mentése</button>
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