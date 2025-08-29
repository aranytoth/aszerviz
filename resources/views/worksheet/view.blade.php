@extends('layouts.public')

@section('content')
    @include('pdf.worksheet', ['worksheet' => $worksheet])
@endsection