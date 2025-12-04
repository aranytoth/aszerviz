@extends('layouts.admin')

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
                @csrf
            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <h4 class="mb-0">{{ trans_db('site.settings') }}</h4>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>
            <div class="row mb-3">
                <label for="site_name-input" class="col-sm-2 col-form-label">Weboldal neve</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{get_option('site_name')}}" placeholder="Honlap neve" name="site_name" id="site_name-input">
                </div>
            </div>
            <div class="row mb-3">
                <label for="site_description-input" class="col-sm-2 col-form-label">Weboldal egysoros leírása</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{get_option('site_description')}}" placeholder="" name="site_description" id="site_description-input">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Weboldal URL</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" disabled value="{{env('APP_URL')}}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="site_image-input" class="col-sm-2 col-form-label">Alapértelmezett megosztási kép</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{get_option('site_image')}}" name="site_image" id="site_image-input">
                </div>
            </div>
            <hr />
            <h4 class="header-title">Admin beálítások</h4>
            <div class="row mb-3">
                <label for="default_admin_email-input" class="col-sm-2 col-form-label">Admin email címe</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" value="{{get_option('default_admin_email')}}" name="default_admin_email" id="default_admin_email-input">
                </div>
            </div>
            <div class="row mb-3">
                <label for="default_admin_url" class="col-sm-2 col-form-label">Admin URL</label>
                <div class="col-sm-10 d-flex align-items-center gap-2">
                    <span>{{env('APP_URL')}}/</span><input class="form-control" type="text" value="{{get_option('default_admin_url','admin')}}" name="default_admin_url" id="default_admin_url-input">
                </div>
            </div>
            <div class="row mb-3">
                <label for="default_admin_login" class="col-sm-2 col-form-label">Login URL</label>
                <div class="col-sm-10 d-flex align-items-center gap-2">
                    <span>{{env('APP_URL')}}/</span><input class="form-control" type="text" value="{{get_option('login_uri','login')}}" name="default_admin_login" id="default_admin_login-input">
                </div>
            </div>
            <button type="submit" class="btn btn-success">Beállítások mentése</button>
            </form>
        </div>
    </div>

@endsection