@extends('layouts.auth')

@section('content')


<div class="col-md-8 col-lg-6 col-xl-5">
    <div class="card">
        <div class="card-body">
            <div class="px-2 py-3">
                <div class="text-center">
                    A szerviz

                    <h5 class="text-primary mb-2 mt-4">Új jelszó beállítása</h5>
                </div>
                    @if (session('status'))
                    <div class="alert alert-success text-center mb-4 mt-4 pt-2" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="useremail">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus id="useremail" placeholder="Email cím">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password">Jelszó</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="email" autofocus id="password" placeholder="Jelszó">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation">Jelszó újra</label>
                        <input type="password" class="form-control @error('email') is-invalid @enderror" name="password_confirmation"  required autocomplete="email" autofocus id="password_confirmation" placeholder="Jelszó újra">
                        
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
</div>



@endsection
