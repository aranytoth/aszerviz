@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h4 class="mb-4">Galéria</h4><button class="btn">Média feltöltése</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <span id="images-con">
                            Húzd ide a fájlt a feltöltéshez, vagy kattins a fájlok kiválasztásához
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div id="gallery-con">
                            
                            @foreach ($media as $image )
                                <div class="gallery-item">
                                    <a href="{{route('media.show', ['media' => $image->id])}}">
                                    <img src="{{$image->hasGeneratedConversion('thumb') 
                        ? $image->getUrl('thumb') 
                        : $image->getUrl()}}" />
                        </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{ $media->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    #images-con {min-height: 100px; background-color: #ddd; border: 1px dashed #222; display: flex; justify-content: center; align-items: center; flex-direction: column; cursor: pointer;}
    #gallery-con {display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px;}
    .gallery-item {}
    .gallery-item img {width: 100%; aspect-ratio: 16/11; object-fit: cover;}
</style>

@endsection

@section('js')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<script>
$(function(){
    $.ajaxSetup({
        headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    var prevFile;
    $("span#images-con").dropzone({
            url: "{{route('media.upload')}}",
            paramName: "image",
            //previewsContainer: ".images-previews",
            //clickable: '.add-image-btn',
            acceptedFiles: 'image/*,audio/*,video/*',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(file, response) {
                location.reload();
    
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
</script>

@endsection