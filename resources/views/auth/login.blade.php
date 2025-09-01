@extends('layouts.auth')

@section('content')
<div class="col-md-8 col-lg-6 col-xl-5">
    <div class="card">
        <div class="card-body">
            <div class="px-2 py-3">
                <div class="text-center">
                    A szerviz
                    <h5 class="text-primary mb-2 mt-4">{{ __('Bejelentkezés') }}</h5>
                    <p class="text-muted">Jelentkezz be!.</p>
                </div>
                <form method="POST" class="form-horizontal mt-4 pt-2" action="{{ route('login') }}">
                @csrf
                    <div class="mb-3">
                        <label for="username">Email</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" required autocomplete="current-email" id="username"
                            placeholder="Email cím" value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="userpassword">Jelszó</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" id="userpassword"
                            placeholder="Enter password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input"
                                id="customControlInline" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-label"
                                for="customControlInline">Emlékezz rám</label>
                        </div>
                    </div>

                    <div>
                        <button class="btn btn-primary w-100 waves-effect waves-light"
                            type="submit">Bejelentkezek</button>
                    </div>
                        @if (Route::has('password.request'))
                    <div class="mt-4 text-center">
                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock me-1"></i> Elfelejtett jelszó?</a>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
     
@endsection
