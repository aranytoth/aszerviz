@extends('layouts.admin')

@section('content')
<script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>
<link href="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css" rel="stylesheet" type="text/css" />
<div class="card">
    <div class="card-body">
        <form action="{{route('company.store')}}" method="POST">
            @csrf
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h4 class="mb-4">Új cég</h4>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Név</label>
                            <input class="form-control" type="text" placeholder="Cég neve" name="company_name" value="{{old('company_name')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Email cím</label>
                            <input class="form-control" type="text" placeholder="Cég email címe" name="company_email" value="{{old('company_email')}}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Irányítószám</label>
                            <input class="form-control" type="text" placeholder="Irányítószám" name="company_zip" value="{{old('company_zip')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Település</label>
                            <input class="form-control" type="text" placeholder="Település" name="company_city" value="{{old('company_city')}}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Cím</label>
                            <input class="form-control" type="text" placeholder="Cím" name="company_address" value="{{old('company_address')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Házszám</label>
                            <input class="form-control" type="text" placeholder="Házszám" name="company_house_num" value="{{old('company_house_num')}}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Adószám</label>
                            <input class="form-control" type="text" placeholder="Adószám" name="company_tax_number" value="{{old('company_tax_number')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Számlázz.hu API kulcs</label>
                            <input class="form-control" type="text" placeholder="Számlázz.hu API kulcs" name="szamlazz_api_key" value="{{old('szamlazz_api_key')}}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Felhasználó hozzárendelése</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="user_id" aria-label="">
                            @foreach ($users as $key => $user)
                            <option value="" selected disabled>Rendelj hozzá felhasználót</option>
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">Létrehoz</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection