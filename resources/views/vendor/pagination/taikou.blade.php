@if ($paginator->hasPages())
    <nav class="taikou-pager" role="navigation" aria-label="Pagination Navigation">

        {{-- Showing ... --}}
        <div class="taikou-pager__meta">
            Showing <span>{{ $paginator->firstItem() }}</span>
            to <span>{{ $paginator->lastItem() }}</span>
            of <span>{{ $paginator->total() }}</span> results
        </div>

        {{-- Buttons --}}
        <ul class="taikou-pager__list">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true">
                    <span class="btn" aria-hidden="true">‹</span>
                </li>
            @else
                <li>
                    <a class="btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous">‹</a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                {{-- "..." --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span class="btn dots">{{ $element }}</span></li>
                @endif

                {{-- Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span class="btn">{{ $page }}</span></li>
                        @else
                            <li><a class="btn" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next">›</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true">
                    <span class="btn" aria-hidden="true">›</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
