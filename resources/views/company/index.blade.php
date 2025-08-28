@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row align-items-center mb-3">
            <div class="col-md-6">
                <h4 class="mb-0">Cégek</h4>
            </div>
            <div class="col-md-6">
                <div class="float-end d-none d-sm-block">
                    <a href="{{route('company.create')}}" class="btn btn-success">Új cég</a>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Név</th>
                        <th>Cím</th>
                        <th>Tulajdonos</th>
                        <th>Státusz</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($companies as $key => $company)
                    <tr>
                        <th scope="row">{{$key+1}}</th>
                        <td>{{$company->company_name}}</td>
                        <td>{{$company->company_zip}} {{$company->company_city}}, {{$company->company_address}} {{$company->company_house_num}}</td>
                        <td>{{$company->created_at}}</td>
                        <td>{{$company->currentStatus}}</td>
                        <td><a href="{{route('company.edit', ['company' => $company->id])}}"><span class="dripicons-pencil"></span></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection