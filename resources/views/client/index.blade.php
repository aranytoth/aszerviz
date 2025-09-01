@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Ügyfelek</h4>
            </div>
            <div class="col-md-6">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Név</th>
                        <th>Email cím</th>
                        <th>Létrehozva</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $key => $client)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$client->name}}</td>
                        <td>{{$client->email}}</td>
                        <td>{{$client->created_at}}</td>
                        <td><a href="{{route('client.view', ['client' => $client->id])}}"><span class="dripicons-preview"></span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection