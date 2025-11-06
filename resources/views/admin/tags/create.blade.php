@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h4 class="mb-4">Új címke</h4>
                    </div>
                </div>
                <form action="{{route('categories.store')}}" method="POST">
                    @csrf
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Név</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label">Keresőbarát név</label>
                        <input type="text" name="slug" class="form-control" value="{{old('slug')}}">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Létrehoz</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection