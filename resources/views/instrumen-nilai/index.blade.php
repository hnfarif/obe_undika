@extends('layouts.main')
@section('instrumen-nilai', 'active')
@section('', 'active')
@section('content')
<section class="section">


    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Rencana Pembelajaran Semester</h4>
                    </div>
                    <div class="card-body d-flex flex-wrap ">

                        <div class="mr-5 w-25">
                            <div class="pricing pricing-highlight">

                                <div class="pricing-padding">
                                    <div class="pricing-price">
                                        <div>TEKNOLOGI BIG DATA</div>
                                        <div>Semester 7 / 3 SKS</div>
                                    </div>
                                </div>
                                <div class="pricing-cta">
                                    <a href="{{ route('kelola.nilai-mhs') }}">Edit Instrumen<i
                                            class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>
    </div>


</section>
@endsection
{{-- @section('script')
<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            // autoplay: false,
            // loop: false,
        })

    })

</script>
@endsection --}}
