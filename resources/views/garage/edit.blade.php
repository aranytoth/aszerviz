@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{route('garage.update', ['garage' => $garage->id ])}}" method="POST">
            @csrf
            @method('PUT')
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h4 class="mb-4">Garázs szerkesztése</h4>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="mb-1">
                            <label class="form-label">Név</label>
                            <input class="form-control" type="text" placeholder="Garázs elnevezése" name="name" value="{{old('name') ?? $garage->name}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-1">
                            <label class="form-label">Email cím</label>
                            <input class="form-control" type="text" placeholder="Kapcsolati email cím" name="email" value="{{old('email') ?? $garage->email}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-1">
                            <label class="form-label">Telefonszám</label>
                            <input class="form-control" type="text" placeholder="Kapcsolati telefonszám" name="phone" value="{{old('phone') ?? $garage->phone}}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Irányítószám</label>
                            <input class="form-control" type="text" placeholder="Irányítószám" name="zip" value="{{old('zip') ?? $garage->zip}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Település</label>
                            <input class="form-control" type="text" placeholder="Település" name="city" value="{{old('city') ?? $garage->city}}">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Cím</label>
                            <input class="form-control" type="text" placeholder="Cím" name="address" value="{{old('address') ?? $garage->address}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Házszám</label>
                            <input class="form-control" type="text" placeholder="Házszám" name="housenum" value="{{old('housenum') ?? $garage->housenum}}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-1">
                            <label class="form-label">Hozzárendelt felhasználó</label>
                            <input class="form-control" type="text" disabled value="{{$garage->user->name}}">
                        </div>
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