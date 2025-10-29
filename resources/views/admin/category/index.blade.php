@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Kategóriák</h4>
            </div>
            <div class="col-md-6">
                <div class="float-end d-none d-sm-block">
                    <a href="{{route('categories.create')}}" class="btn btn-success">Új kategória</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cím</th>
                        <th>Slug</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model as $key => $category)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td><a href="{{route('categories.edit', ['category' => $category->id])}}"><span class="dripicons-pencil"></span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection