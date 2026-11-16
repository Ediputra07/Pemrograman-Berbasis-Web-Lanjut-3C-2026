@props(['buku']) <!-- menerima data bernama buku -->

<div class="book-card">
    <h3>{{ $buku['judul'] }}</h3>
    <p><strong>Penulis:</strong> {{ $buku['penulis'] }}</p>
    <p><strong>Tahun Terbit:</strong> {{ $buku['tahun_terbit'] }}</p>

    <!-- Implementasi Named Slot / Default Slot -->
    @if (isset($badge))
        <div class="slot-badge">
            {{ $badge }}
        </div>
    @endif

    <div class="card-action">
        <a href="{{ route('buku.show', ['id' => $buku['id']]) }}" class="btn">Lihat Detail</a>
    </div> <!-- ini hnya untuk meilhat detal buku-->
</div>