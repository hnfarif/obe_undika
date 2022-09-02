@extends('layouts.main')
@section('beranda', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="col-12 mb-4">
                    <div class="hero text-white hero-bg-image hero-bg-parallax"
                        data-background="../assets/img/unsplash/andre-benz-1214056-unsplash.jpg">
                        <div class="hero-inner">
                            <h2>Welcome, {{ auth()->user()->karyawan->nama }}!</h2>
                            <div class="mt-4">
                                <p class="lead">Role sekarang</p>
                                <a href="#" class="btn btn-outline-white btn-lg btn-icon icon-left" data-toggle="modal"
                                    data-target="#modalRole"><i class="far fa-user"></i>
                                    {{ strtoupper(auth()->user()->role) }} </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('layouts.footer')
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalRole">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Role anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateRole') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" value="{{ auth()->user()->nik }}">
                    <div class="form-group">
                        <label>Pilih Role</label>
                        <select class="form-control" name="role">
                            <option value="" disabled selected>Pilih role</option>
                            @foreach ($roles as $i)
                            <option value="{{ $i }}">{{ strtoupper($i) }}</option>
                            @endforeach
                        </select>
                    </div>

            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('script')



@endpush
