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
        <div class="row">
            <div class="col-md-12">
                <form action="" method="GET">
                <table class="table w-100">
                    <tr>
                        <td>
                            <label class="form-label">Keresés</label>
                            <input type="text" class="form-control" name="worksheet" value="{{$params['worksheet'] ?? ''}}">
                        </td>
                        <td>
                            <label class="form-label">Dátum</label>
                            <input type="date" class="form-control" name="created_at" value="$params['created_at'] ?? ''"></td>
                        <td>
                            <label class="form-label">Szerelő</label>
                            <select name="user" class="form-select">
                                @foreach ($users as $key => $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <label class="form-label">Állapot</label>
                            <select class="form-select" name="status">
                                @foreach ($statuses as $key => $status)
                                    <option value="{{$key}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-success">Keresés</button>
                        </td>
                    </tr>
                </table>
                </form>
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
                        <th>Felvétel ideje</th>
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
                            <td>{{$worksheet->created_at->format('Y-m-d H:i:s')}}</td>
                            <td><a href="{{route('worksheet.edit', ['worksheet' => $worksheet->id])}}"><span class="dripicons-pencil"></span></a></td>
                        </tr>
                    @endforeach
                    
                   
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection