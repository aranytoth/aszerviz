@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{route('users.store')}}" method="POST">
            @csrf
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h4 class="mb-4">Új felhasználó</h4>
                </div>

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Név</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" placeholder="Felhasználó neve" name="name">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Email cím</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" placeholder="Felhasználó email címe" name="email">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Munkavégzés helye</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="garage_id">
                            @foreach ($garages as $key => $garage)
                            <option value="{{$garage->id}}">{{$garage->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jogosultság</label>
                    <div class="col-sm-10">
                        <select class="form-select" name="role">
                            @foreach ($roles as $key => $role)
                            <option value="{{$key}}">{{$role}}</option>
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