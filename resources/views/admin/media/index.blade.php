@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h4 class="mb-4">Galéria</h4>
                    </div>
                </div>
                <div class="row">
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
            </div>
        </div>
    </div>
</div>

<style>
    #gallery-con {display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px;}
    .gallery-item {}
    .gallery-item img {width: 100%; aspect-ratio: 16/11; object-fit: cover;}
</style>

@endsection

@section('js')

<script>
(function() {
    
})();
</script>

@endsection