{{-- resources/views/vendor/pagination/simple.blade.php --}}
@if ($paginator->hasPages())
<nav>
    <ul class="pagination justify-content-center">
        {{-- Previous Page Link --}}
        <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        <li class="page-item {{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</nav>
@endif