@extends('layouts.main')
@section('rps', 'active')
@section('step1', 'active')
@section('content')
<section class="section">


    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Rencana Pembelajaran Semester</h4>
                        <div class="card-header-action">
                            <a href="#" class="btn btn-danger btn-icon icon-right">View All <i
                                    class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="owl-carousel owl-theme" id="rps-carousel">
                            <div>
                                <div class="pricing pricing-highlight">
                                    <div class="pricing-title">
                                        Belum Selesai
                                    </div>
                                    <div class="pricing-padding">
                                        <div class="pricing-price">
                                            <div>TEKNOLOGI BIG DATA</div>
                                            <div>Semester 7 / 3 SKS</div>
                                        </div>
                                    </div>
                                    <div class="pricing-cta">
                                        <a href="#">EDIT RPS<i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="pricing ">
                                    <div class="pricing-title">
                                        Selesai
                                    </div>
                                    <div class="pricing-padding">
                                        <div class="pricing-price">
                                            <div class="">Sistem Pendukung Keputusan</div>
                                            <div>Semester 7 / 3 SKS</div>
                                        </div>
                                    </div>
                                    <div class="pricing-cta">
                                        <a href="#">Lihat RPS <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="pricing pricing-highlight">
                                    <div class="pricing-title">
                                        Selesai
                                    </div>
                                    <div class="pricing-padding">
                                        <div class="pricing-price">
                                            <div>Kecerdasan Bisnis</div>
                                            <div>Semester 7 / 3 SKS</div>
                                        </div>
                                    </div>
                                    <div class="pricing-cta">
                                        <a href="#">EDIT RPS<i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="pricing ">
                                    <div class="pricing-title">
                                        Belum Selesai
                                    </div>
                                    <div class="pricing-padding">
                                        <div class="pricing-price">
                                            <div class="">Matematika Bisnis</div>
                                            <div>Semester 7 / 3 SKS</div>
                                        </div>
                                    </div>
                                    <div class="pricing-cta">
                                        <a href="#">EDIT RPS <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="pricing pricing-highlight">
                                    <div class="pricing-title">
                                        Selesai
                                    </div>
                                    <div class="pricing-padding">
                                        <div class="pricing-price">
                                            <div>ARsitektur Enterprise</div>
                                            <div>Semester 7 / 3 SKS</div>
                                        </div>
                                    </div>
                                    <div class="pricing-cta">
                                        <a href="#">EDIT RPS<i class="fas fa-arrow-right"></i></a>
                                    </div>
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
