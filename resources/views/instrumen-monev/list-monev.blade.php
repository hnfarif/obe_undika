@extends('layouts.main')
@section('instrumen-monev', 'active')
@section('', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                @if (session()->has('message'))
                <div class="alert {{ session()->get('alert-class') }} alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <div class="my-3 d-flex">
                    @if (auth()->user()->role != 'dosen')
                    <button class="btn btn-light ml-auto" data-toggle="modal" data-target="#filMon">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    @endif
                    <form class="card-header-form ml-3 @if (auth()->user()->role == 'dosen') ml-auto @endif"
                        action="{{ route('monev.listMonev') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama matakuliah"
                                value="{{ request('search') }}">
                            <div class="input-group-btn d-flex">
                                <button class="btn btn-primary btn-icon"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
                    @if (auth()->user()->role == 'dosen')

                    @include('instrumen-monev.role.dosen')

                    @else

                    @include('instrumen-monev.role.beside')

                    @endif

                </div>
                @if ($pltMnv->hasPages())
                <div class="pagination-wrapper d-flex justify-content-end">
                    {{ $pltMnv->links() }}
                </div>

                @endif
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>
@include('instrumen-monev.modal')
@endsection
@push('script')
@include('instrumen-monev.list-monev-script')
@endpush
