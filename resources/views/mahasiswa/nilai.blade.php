@extends('mahasiswa.layout')
@section('content')
<div class="container mt-3">
        <h2 class="text-center mb-5">MAHASISWA JURUSAN TEKNOLOGI INFORMASI</h3>
        <h2 class="text-center mb-4">KARTU HASIL STUDI (KHS)</h2>

        <br><br><br>

        <b>Nama: </b> {{ $mhs->mahasiswa->nama}}<br>
        <b>Kelas: </b> {{ $mhs->mahasiswa->kelas->nama_kelas}}<br>
        <b>NIM: </b>{{ $mhs->mahasiswa->nim}}<br>

        <br>
        <table class="table table-bordered">
            <tr>
            <th>Matakuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
            </tr>
            @foreach ($mhs as $n)
            <tr>
            <td>{{ $n->matakuliah->nama_matkul }}</td>
            <td>{{ $n->matakuliah->sks }}</td>
            <td>{{ $n->matakuliah->semester }}</td>
            <td>{{ $n->nilai  }}</td>
            </tr>
            @endforeach
            </table>
    </div>
@endsection 
