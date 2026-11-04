@if ($paginator->hasPages())
    <nav style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;" aria-label="Navigasi halaman">

        {{-- Tombol Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="btn" style="opacity:.4; cursor:not-allowed; padding:8px 14px; font-size:13px;">&laquo; Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn" style="padding:8px 14px; font-size:13px;" rel="prev">&laquo; Sebelumnya</a>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="btn" style="padding:8px 14px; font-size:13px; opacity:.5; cursor:default;">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="btn btn-solid" style="padding:8px 14px; font-size:13px;" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="btn" style="padding:8px 14px; font-size:13px;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Tombol Selanjutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn" style="padding:8px 14px; font-size:13px;" rel="next">Selanjutnya &raquo;</a>
        @else
            <span class="btn" style="opacity:.4; cursor:not-allowed; padding:8px 14px; font-size:13px;">Selanjutnya &raquo;</span>
        @endif

    </nav>
@endif