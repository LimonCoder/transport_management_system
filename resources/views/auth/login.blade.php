@extends('layouts.app')


@section('title','Login')

@section('main-content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5 mt-4">
            <div class="card">

                <div class="card-body p-4">

                    <div class="text-center mb-4">
                       <img src="{{ asset('/assets/images/logo.png') }}" width="100%">
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                   name="username" value="{{ old('username') }}" required autocomplete="username"
                                   autofocus placeholder="ইউজারনেম">
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid
@enderror" name="password" required autocomplete="current-password" placeholder="পাসওর্য়াড">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-block" type="submit"> লগইন </button>
                        </div>

                    </form>


                </div> <!-- end card-body -->
            </div>
            <!-- end card -->


            <!-- end row -->

        </div> <!-- end col -->
    </div>
</div>
@endsection
