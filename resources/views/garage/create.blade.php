@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('garage.store')}}" method="POST">
            @csrf
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h4 class="mb-4">Új garázs</h4>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="mb-1">
                            <label class="form-label">Név</label>
                            <input class="form-control" type="text" placeholder="Garázs elnevezése" name="name" value="{{old('name')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-1">
                            <label class="form-label">Email cím</label>
                            <input class="form-control" type="text" placeholder="Kapcsolati email cím" name="email" value="{{old('email')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-1">
                            <label class="form-label">Telefonszám</label>
                            <input class="form-control" type="text" placeholder="Kapcsolati telefonszám" name="phone" value="{{old('phone')}}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Irányítószám</label>
                            <input class="form-control" type="text" placeholder="Irányítószám" name="zip" value="{{old('zip')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Település</label>
                            <input class="form-control" type="text" placeholder="Település" name="city" value="{{old('city')}}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Cím</label>
                            <input class="form-control" type="text" placeholder="Cím" name="address" value="{{old('address')}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Házszám</label>
                            <input class="form-control" type="text" placeholder="Házszám" name="housenum" value="{{old('housenum')}}">
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