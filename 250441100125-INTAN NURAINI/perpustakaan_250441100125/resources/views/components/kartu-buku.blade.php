<div class="book-card">

    <div class="book-content">
        <h3>{{ $judul }}</h3>

        <p>
            <strong>Penulis:</strong> {{ $penulis }}
        </p>

        <p>
            <strong>Tahun:</strong> {{ $tahun }}
        </p>

        {{ $slot }}

        <a href="{{ route('buku.show', $id) }}" class="btn">
        Lihat Detail
        </a>
    </div>

</div>