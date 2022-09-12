@component('mail::message')
# Hai, {{ $dosen->nama }}

Anda telah ditambahkan sebagai penyusun RPS {{ $rps->nama_mk }}, harap segera melakukan penyusunan RPS tersebut.

@component('mail::button', ['url' => route('clo.index', $rps->id)])
Lihat RPS
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
