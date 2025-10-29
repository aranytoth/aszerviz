@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Fordítások</h4>
            </div>
            <div class="col-md-6">
                <div class="float-end d-none d-sm-block">
                    <a href="{{route('translations.create')}}" class="btn btn-success">Új fordítás</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Megnevezés</th>
                        <th>Csoport</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $key => $tr)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$tr->key}}</td>
                        <td>{{$tr->group}}</td>
                        <td><a href="{{route('translations.edit', ['translation' => $tr->id])}}"><span class="dripicons-pencil"></span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection