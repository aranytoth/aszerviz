@extends('layouts.admin')


@section('content')
<link href="{{ asset('static/libs/cropper/cropper.min.css') }}" rel="stylesheet" type="text/css" />

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div id="image-editor-img">
                    <img src="{{$media->getUrl()}}" />
                </div>
                <div id="editor-buttons" class="mt-3">
                    <button data-value="1.7777777777777777" class="btn btn-primary img-aspect-ratio">16:9</button>
                    <button data-value="1" class="btn btn-primary img-aspect-ratio">1:1</button>
                    <button data-value="1.3333333333333333" class="btn btn-primary img-aspect-ratio">4:3</button>
                    <button data-value="NaN" class="btn btn-primary img-aspect-ratio">Free</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('static/libs/cropper/cropper.min.js') }}"></script>

<script>

(function(){
    const imgContainer = document.querySelector('#image-editor-img img');
    const arButtons = document.querySelectorAll('.img-aspect-ratio');
    let cropper;

    cropper = new Cropper(imgContainer, {
        aspectRatio: NaN,
        crop(event) {
            
        },
        ready() {
             
             //this.cropper.crop();
            arButtons.forEach(btn => {
                btn.addEventListener('click',(e) => {
                    console.log(btn.dataset.value);
                    console.log(this.cropper);
                    this.cropper.setAspectRatio(btn.dataset.value);
                    this.cropper.crop();
                })
            })
        }
        });

       

        
})();
</script>

@endsection