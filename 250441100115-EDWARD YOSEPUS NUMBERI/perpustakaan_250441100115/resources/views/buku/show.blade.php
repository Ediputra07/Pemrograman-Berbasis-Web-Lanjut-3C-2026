@extends('layouts.app')

@section('content')
    @if ($buku)
        <div class="card">
            <h2>Detail Buku</h2>
            <hr><br>
            <table class="detail-table">
                <tr>
                    <th>ID Buku</th>
                    <td>: {{ $buku['id'] }}</td>
                </tr>
                <tr>
                    <th>Judul Buku</th>
                    <td>: {{ $buku['judul'] }}</td>
                </tr>
                <tr>
                    <th>Penulis</th>
                    <td>: {{ $buku['penulis'] }}</td>
                </tr>
                <tr>
                    <th>Tahun Terbit</th>
                    <td>: {{ $buku['tahun_terbit'] }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>: {{ $buku['kategori'] }}</td>
                </tr>
            </table>
            <br>
            <a href="{{ route('buku.index') }}" class="btn-back">&laquo; Kembali ke Daftar Buku</a>
        </div>
    @else
        <div class="card alert-danger">
            <h2>Buku Tidak Ditemukan</h2>
            <p>Maaf, data buku dengan ID tersebut tidak tersedia di dalam sistem.</p>
            <br>
            <a href="{{ route('buku.index') }}" class="btn-back">&laquo; Kembali ke Daftar Buku</a>
        </div>
    @endif
@endsection