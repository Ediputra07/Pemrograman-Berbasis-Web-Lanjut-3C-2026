{{-- Paginasi sederhana (tanpa Tailwind). Pakai: @include('partials.paginasi', ['paginator' => $daftar]) --}}
@if ($paginator->hasPages())
    <div class="paginasi">
        @if ($paginator->onFirstPage())
            <span class="tombol tombol--kecil tombol--sekunder tombol--nonaktif" aria-disabled="true">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="tombol tombol--kecil tombol--sekunder" aria-label="Halaman sebelumnya">&laquo;</a>
        @endif

        <span>Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }} ({{ $paginator->total() }} data)</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="tombol tombol--kecil tombol--sekunder" aria-label="Halaman berikutnya">&raquo;</a>
        @else
            <span class="tombol tombol--kecil tombol--sekunder tombol--nonaktif" aria-disabled="true">&raquo;</span>
        @endif
    </div>
@endif
