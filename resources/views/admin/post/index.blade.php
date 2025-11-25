@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Bejegyzések</h4>
            </div>
            <div class="col-md-6">
                <div class="float-end d-none d-sm-block">
                    <a href="{{route('post.create')}}" class="btn btn-success">Új bejegyzés</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cím</th>
                        <th>Tulajdonos</th>
                        <th>Státusz</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $key => $page)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$page->title}}</td>
                        
                        <td>{{$page->created_at}}</td>
                        <td>{{$page->currentStatus}}</td>
                        <td><a href="{{route('post.edit', ['page' => $page->id])}}"><span class="dripicons-pencil"></span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection