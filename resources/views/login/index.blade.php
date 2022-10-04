@extends('layouts.main')
@section('content')
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Login OBE</h4>
                    </div>
                    @if (session()->has('message'))
                    <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('authenticate') }}" class="needs-validation" novalidate="">
                            @csrf
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input id="nik" type="number" value="{{ old('nik') }}" class="form-control @error('nik')
                                    is-invalid
                                @enderror" name="nik" tabindex="1" required autofocus>

                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="pin" class="control-label">PIN</label>
                                </div>
                                <input id="pin" type="password" class="form-control" name="password" tabindex="2"
                                    required>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>
                        {{-- <div class="text-center mt-4 mb-3">
                            <div class="text-job text-muted">Login With Social</div>
                        </div>
                        <div class="row sm-gutters">
                            <div class="col-12">
                                <a href="{{ route('user.login.google') }}" class="btn btn-block btn-social btn-google">
                        <span class="fab fa-google"></span> Google
                        </a>
                    </div>
                </div> --}}

            </div>
        </div>
        <div class="simple-footer">
            Copyright &copy; PPTI 2022
        </div>
    </div>
    </div>
    </div>
</section>
@endsection
