@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Gépjárművek</h4>
            </div>
            <div class="col-md-6">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Rendszám</th>
                        <th>Típus</th>
                        <th>Tulajdonos</th>
                        <th>Létrehozva</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $key => $vehicle)
                    <tr>
                        <td scope="row">{{$key+1}}</td>
                        <td>{{$vehicle->license_plate}}</td>
                        <td>{{$vehicle->brand}}</td>
                        <td>{{$vehicle->latestSheet->client->name}}</td>
                        <td>{{$vehicle->created_at}}</td>
                        <td><a href="{{route('vehicle.view', ['vehicle' => $vehicle->id])}}"><span class="dripicons-preview"></span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection