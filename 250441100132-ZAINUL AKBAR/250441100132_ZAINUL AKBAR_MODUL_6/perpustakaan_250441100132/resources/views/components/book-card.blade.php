<div class="book-card">

    <h3>{{ $judul }}</h3>

    <p><strong>Penulis:</strong> {{ $penulis }}</p>

    <p><strong>Tahun Terbit:</strong> {{ $tahun }}</p>

    <p><strong>Kategori:</strong> {{ $kategori }}</p>

    <a href="{{ route('buku.show', $id) }}">
        Lihat Detail
    </a>

</div>

