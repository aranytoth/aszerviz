@extends('layouts.auth')

@section('content')
<div class="col-md-8 col-lg-6 col-xl-5">
    <div class="card">
        <div class="card-body">
            <div class="px-2 py-3">
                <div class="text-center">
                    A szerviz

                    <h5 class="text-primary mb-2 mt-4">Elfelejtett jelszó</h5>
                </div>
                    @if (session('status'))
                    <div class="alert alert-success text-center mb-4 mt-4 pt-2" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" class="form-horizontal"  action="{{ route('password.email') }}">
                @csrf
                    <div class="mb-3">
                        <label for="useremail">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="useremail" placeholder="Email cím">
                    </div>
                    <div class="row mb-0">
                        <div class="col-12 text-end">
                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Jelszóemlékezető kérése</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="mt-5 text-center text-white">
        <p>Eszedbe jutott? <a href="{{route('login')}}" class="fw-bold text-white"> Itt beléphetsz</a> </p>
    </div>
</div>

@endsection
