@extends('layouts.main')
@section('instrumen-nilai', 'active')
@section('', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                @if (auth()->user()->role == 'dosen')
                @include('instrumen-nilai.role.dosen')
                @else
                @include('instrumen-nilai.role.another')
                @endif
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>

@include('instrumen-nilai.modal')
@endsection

@push('script')
@include('instrumen-nilai.script')
@endpush
