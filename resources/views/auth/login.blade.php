@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Login') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" arialabel="{{ __('Login') }}">
                        @csrf
                        <div class="form-group row mb-6">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-6">
                            <label for="password" class="col-md-4 col-formlabel text-md-right">{{ __('Password') }}</label>
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="flex justify-between mb-0">
                            <div class="form-group">
                                <div class="">
                                    <button type="submit" class="btn btn-primary active">{{ __('Login') }}</button>
                                </div>
                                
                            </div>
                           <a href="{{ route('register') }}" class="nav-link ">
                                <div class="">
                                    <button class="btn btn-success active">{{ __('Register') }}</button>
                                </div>
                                
                            </a> 
                        </div> --}}
                        <div class="row align-items-center">
                            <div class="col-2 ">
                                <button type="submit" class="btn btn-primary active">
                                    {{ __('Login') }}
                                </button>
                            </div>
                            <p class="col-10">belum punya akun?<a class="text-blue-700" href="{{ route('register') }}">Registrasi</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection