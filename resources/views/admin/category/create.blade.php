@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-6">
                        <h4 class="mb-4">Új kategória</h4>
                    </div>
                </div>
                <div class="lang-selector">
                    <ul>
                        @foreach (config('app.available_locales', ['hu', 'en']) as $key => $lang)
                            <li><label for="lang-{{$lang}}" class="{{$key == 0 ? 'selected' : ''}}">{{strtoupper($lang)}}</label></li>
                        @endforeach
                    </ul>
                </div>
                <form action="{{route('categories.store')}}" method="POST">
                    @csrf
                @foreach (config('app.available_locales', ['hu', 'en']) as $key => $lang)
                    <input type="radio" name="lang-selector" class="lang-selector-input" id="lang-{{$lang}}" {{$key == 0 ? 'checked' : ''}}>
                    <div class="row mb-3 lang-block">
                        <div class="col-md-12">
                            <label class="form-label">Név</label>
                            <input type="text" name="name[{{$lang}}]" class="form-control" value="{{old('name')}}">
                        </div>
                    </div>
                    @endforeach
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Keresőbarát név</label>
                            <input type="text" name="slug" class="form-control" value="{{old('slug')}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Szülő kategória</label>
                            <select name="parent_id" class="form-select">
                                <option value="0">Semmi</option>
                                @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Létrehoz</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection