@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{$media->getUrl()}}" style="height: 100%; max-height: 400px;"/>
            </div>
            <div class="col-md-12 mt-3 mb-3 text-center">
                <a href="{{route('media.edit', ['media' => $media->id])}}" class="btn btn-secondary btn-sm">Kép szerkesztése</a>
            </div>
        </div>
        
    </div>
    <div class="col-md-4">
        <form action="{{route('media.update', ['media' => $media->id])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-12">
                    <small>Feltölve: {{$media->created_at->format('Y. m. d. H:i:s')}}</small>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <small>Fájlnév: {{$media->file_name}}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <small>Fájl típusa: {{$media->mime_type}}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <small>Fájlméret: {{number_format($media->size / 1048576, 2)}} MB</small>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <small>Fájl URL: {{$media->getUrl()}}</small><button id="copy-to-clipboard" data-text="{{$media->getUrl()}}" class="btn btn-sm">Másolás vágólapra</button>
                </div>
            </div>
            <hr />
            <div class="row">
                <label div class="col-form-label col-md-2">Kép címe</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="name" value="{{$media->name}}" />
                </div>
            </div>
            <button type="submit" class="btn btn-success">Módosítás</button>
        </form>
    </div>
</div>

@endsection

@section('js')

<script>
    (function(){
        const clipboardBtn = document.querySelector('#copy-to-clipboard');
        clipboardBtn.addEventListener('click', function(e){
            e.preventDefault();
            navigator.clipboard.writeText(clipboardBtn.dataset).then(function() {
            console.log('Async: Copying to clipboard was successful!');
            }, function(err) {
            console.error('Async: Could not copy text: ', err);
            });
        })
    })();
</script>

@endsection