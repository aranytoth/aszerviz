@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-body">
        <form action="{{route('users.update',['user' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h4 class="mb-4">{{$user->name}} szerkesztése</h4>
                </div>

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Név</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" placeholder="Felhasználó neve" name="name" value="{{old('name') ?? $user->name}}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Email cím</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="text" placeholder="Felhasználó email címe" name="email" value="{{old('email') ?? $user->email}}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Jogosultság</label>
                    <div class="col-sm-3">
                        <select class="form-select" name="role">
                            @foreach ($roles as $key => $role)
                            <option value="{{$key}}" {{in_array($key, $user->getRoleNames()->toArray()) ? 'selected' : '' }}>{{$role}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Státusz</label>
                    <div class="col-sm-3">
                        <select class="form-select" name="status">
                            @foreach ($statuses as $key => $status)
                            <option value="{{$key}}" {{$key == $user->status ? 'selected' : '' }}>{{$status}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary" type="submit">Módosít</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection