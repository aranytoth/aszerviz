@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Munkalapok</h4>
            </div>
            <div class="col-md-6">
                <div class="float-end d-none d-sm-block">
                    <a href="{{route('worksheet.create')}}" class="btn btn-success">Új munkalap</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Munkalap száma</th>
                        <th>Gépjármű</th>
                        <th>Munka megnevezése</th>
                        <th>Szerelő</th>
                        <th>Állapot</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $key =>$worksheet)
                        <tr>
                            <td scope="row">{{$key+1}}</td>
                            <td>{{$worksheet->worksheet_id}}</td>
                            <td>{{$worksheet->vehicle->license_plate}} {{$worksheet->vehicle->brand}}</td>
                            <td>{{$worksheet->name}}</td>
                            <td>{{$worksheet->mechanic->name}}</td>
                            <td>{{$worksheet->currentStatus}}</td>
                            <td><a href="{{route('worksheet.edit', ['worksheet' => $worksheet->id])}}"><span class="dripicons-pencil"></span></a></td>
                        </tr>
                    @endforeach
                    
                   
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection