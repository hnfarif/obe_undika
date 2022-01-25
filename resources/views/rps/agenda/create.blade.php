@extends('layouts.main')
@section('rps', 'active')
@section('agenda', 'active')
@section('content')

<section class="section">
    @include('rps.section-header')
    <div class="section-body">
        <div class="row row-input">
            <div class="col-12 col-md-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Entri Agenda Pembelajaran</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Minggu ke</label>
                                    <input type="text" readonly class="form-control" value="Minggu ke 1">
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>Kode CLO</label>
                                    <select class="form-control select2">
                                        <option>CLO-01 - Mahasiswa mampu menguraikan dan memilih aktivitas analisis Big
                                            Data yang sesuai
                                            dengan konteks masalah bisnis dalam organisasi.</option>
                                        <option>CLO-02 - Mampu membuat model deskripsi dan prediksi dengan mengambil
                                            potensi dari Big Data menggunakan metode-metode analitikal data sebagai
                                            dasar pengambilan keputusan yang sesuai dengan kebutuhan organisasi.
                                        </option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="section-title mt-0">Deskripsi Sub CLO (LLO)</div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Kode LLO</label>
                                    <select class="form-control select2">
                                        <option>LLO1 - Mahasiswa mampu memahami konsep dasar manajemen dan analisis pada
                                            Big Data </option>

                                        <option>LLO2 - Mahasiswa mampu menguraikan tentang teknologi Big Data.</option>
                                        <option>LLO3 - Mahasiswa mampu mencari Pattern dan Insight dari data sesuai
                                            kebutuhan organisasi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>Ketercapaian LLO</label>

                                    <select class="form-control select2" multiple="">

                                        <option value="1">Mahasiswa memahami silabus, kontrak perkulihan, dan ruang
                                            lingkup
                                            perkuliahan Teknologi Big Data.</option>
                                        <option value="2">Mahasiswa memahami konsep dasar Big Data</option>
                                        <option value="3">Mahasiswa dapat menguraikan tentang daur hidup analisis Big
                                            Data
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="section-title mt-0">Bentuk Penilaian</div>
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="form-group">
                                    <label>Bentuk Penilaian</label>
                                    <select class="form-control select2">
                                        <option>Menyampaikan Pendapat (1%)</option>
                                        <option>Tugas Mandiri 4%</option>
                                        <option>Tugas Kelompok 3%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">

                                <div class="form-group">
                                    <label>Deskripsi Penilaian</label>
                                    <textarea name="" id="" style="height: 100px" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="section-title mt-0">Materi</div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Bahan Kajian</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Materi</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="" aria-label="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Pustaka</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="" aria-label="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Media Pembelajaran</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="" aria-label="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Metode Pembelajaran</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="" aria-label="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">Tambah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card ">
                                    <div class="card-header">
                                        <h4>Daftar Materi, Pustaka, dan Media Pembelajaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="accordion">
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#materi" aria-expanded="true">
                                                    <h4>Materi</h4>
                                                </div>
                                                <div class="accordion-body collapse show" id="materi"
                                                    data-parent="#accordion">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Karakteristik Big Data (konsep 5V’s
                                                                    : Volume, Velocity, Variety, Veracity, Value)
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Pengantar perkuliahan Teknologi Big Data.
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Wawasan industri saat ini terkait Big Data.
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>

                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#pustaka">
                                                    <h4>Pustaka</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="pustaka"
                                                    data-parent="#accordion">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Dietrich, D., Heller, B., & Yang, B. (2015). Data
                                                                    Science and Big Data Analytics. John Wiley & Sons
                                                                    Ltd.
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Trovati, M., Hill, R., Anjum, A., & Ying Zhu, S.
                                                                    (2016). Big-Data Analytics and Cloud Computing:
                                                                    Theory, Algorithms and Applications. Springer
                                                                    Switzerland.
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Corea, F. (2019). An Introduction to Data -
                                                                    Everything You Need to Know About AI, Big Data and
                                                                    Data Science. Springer Nature Switzerland.
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#medpem">
                                                    <h4>Media Pembelajaran</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="medpem"
                                                    data-parent="#accordion">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Slide power point dari dosen
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Video dari youtube
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="accordion">
                                                <div class="accordion-header" role="button" data-toggle="collapse"
                                                    data-target="#metode">
                                                    <h4>Metode Pembelajaran</h4>
                                                </div>
                                                <div class="accordion-body collapse" id="metode"
                                                    data-parent="#accordion">
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Lecture
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Discovery Learning
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    Discussion
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <a href="#" class="btn btn-danger"><i
                                                                            class="fas fa-trash"></i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="section-title mt-0">Kuliah</div>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Tatap Muka</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Synchronous Learning</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Asynchronous Learning</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Assessment</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Responsi dan Tutorial (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Belajar Mandiri (menit/mg)</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Praktikum</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary">Tambah Minggu ke 1</button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@section('script')

{{-- <script src="{{ asset('assets/js/page/forms-advanced-forms.js') }}"></script> --}}
<script>
    $(document).ready(function () {
        // $('.expanded').on('click', function () {
        //     $('.row-input').removeAttr('hidden');
        //     $('.minimized').removeAttr('hidden');
        //     $('.expanded').attr('hidden', 'hidden');
        // })
        // $('.minimized').on('click', function () {
        //     $('.row-input').attr('hidden', 'hidden');
        //     $('.minimized').attr('hidden', 'hidden');
        //     $('.expanded').removeAttr('hidden');
        // })

    })

</script>
@endsection
