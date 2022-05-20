@extends('layouts.main')
@section('instrumen-nilai', 'active')
@section('', 'active')
@section('content')
<div class="main-wrapper container">
    @include('layouts.navbar')
    <div class="main-content">
        <section class="section">

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Mata Kuliah</h4>
                            </div>
                            <div class="card-body">

                                <table class="table table-striped" id="tableJdw">
                                    <thead>
                                        <tr>

                                            <th>Kode MK</th>
                                            <th>Mata Kuliah</th>
                                            <th>Kelas</th>
                                            <th>Ruang</th>
                                            <th>Prodi</th>
                                            <th>SKS</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jdwkul as $jdw)

                                        <tr>
                                            <td>{{ $jdw->klkl_id }}</td>
                                            <td>{{ $jdw->getNameMataKuliah($jdw->klkl_id,$jdw->prodi) }}</td>
                                            <td>{{ $jdw->kelas }}</td>
                                            <td>{{ $jdw->ruang_id }}</td>
                                            <td>{{ $jdw->getNameProdi($jdw->prodi) }}</td>
                                            <td>{{ $jdw->sks }}</td>
                                            <td><button data-mk="{{ $jdw->prodi.$jdw->klkl_id }}"
                                                    class="btn btn-primary btnUbahNilai">Penilaian CLO</button>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>


        </section>
    </div>
    @include('layouts.footer')
</div>
@endsection

@push('script')
<script>
    $("#tableJdw").DataTable();
    $(document).ready(function () {

        $(".btnUbahNilai").on('click', function () {
            // window.location.href = "{{ url('/instrumen-nilai/create') }}";
            $.ajax({
                url: "{{  route('penilaian.cekrps') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    'kode_mk': $(this).data('mk'),
                },
                success: function (data) {
                    console.log(data);
                    if ($.isEmptyObject(data.error)) {
                        window.location.href = data.url;
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Ada yang salah!',
                            text: data.error,
                        })

                    }
                }

            })
        })

    })

</script>
@endpush
