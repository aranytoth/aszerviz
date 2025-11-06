@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Új statikus fordítás</h4>
            </div>
        </div>
        <form action="{{route('translations.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-10">
                    <div class="mb-4">
                        <label>Csoport:</label>
                        <select name="Translation[group]" class="form-select">
                            @foreach($groups as $g)
                                <option value="{{$g}}" >{{ $g }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label>Név:</label>
                        <input type="text" name="Translation[key]" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    @foreach ($locales as $locale)
                        <label>{{$locale}}</label>
                        <input name="TranslationValues[{{$locale}}]" class="form-control">
                    @endforeach
                </div>
                
            </div>
            <button type="submit" class="btn btn-success mt-4">{{trans_db('common.create')}}</button>
        </form>
    </div>
</div>

@endsection