@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Garászok</h4>
            </div>
            <div class="col-md-6">
                <div class="float-end d-none d-sm-block">
                    <a href="{{route('garage.create')}}" class="btn btn-success">Új garázs</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Garázs elnevezése</th>
                        <th>Cím</th>
                        <th>Garázsvezető</th>
                        <th>Státusz</th>
                        <th>Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($garages as $key => $garage)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$garage->name}}</td>
                        <td>{{$garage->zip}} {{$garage->city}}, {{$garage->address}} {{$garage->housenum}}</td>
                        <td></td>
                        <td>{{$garage->currentStatus}}</td>
                        <td><a href="{{route('garage.edit', ['garage' => $garage->id])}}"><span class="dripicons-pencil"></span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection