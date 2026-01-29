@if ($paginator->hasPages())
  <nav role="navigation" aria-label="Pagination Navigation"
       style="margin-top:16px; display:flex; justify-content:center;">
    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">

      {{-- Previous --}}
      @if ($paginator->onFirstPage())
        <span style="
          padding:8px 12px; border-radius:999px;
          border:2px solid var(--border,#dbeafe);
          background:#fff; opacity:.45; font-weight:900;">
          ‹ 前へ
        </span>
      @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="
          padding:8px 12px; border-radius:999px;
          border:2px solid var(--border,#dbeafe);
          background:#fff; font-weight:900; color:var(--text-blue,#3b82f6);
          text-decoration:none;">
          ‹ 前へ
        </a>
      @endif

      {{-- Page Numbers --}}
      @foreach ($elements as $element)
        {{-- "..." --}}
        @if (is_string($element))
          <span style="
            padding:8px 12px; border-radius:999px;
            border:2px solid var(--border,#dbeafe);
            background:#fff; opacity:.6; font-weight:900;">
            {{ $element }}
          </span>
        @endif

        {{-- Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <span aria-current="page" style="
                padding:8px 12px; border-radius:999px;
                border:2px solid var(--text-blue,#3b82f6);
                background:var(--text-blue,#3b82f6);
                color:#fff; font-weight:900;">
                {{ $page }}
              </span>
            @else
              <a href="{{ $url }}" style="
                padding:8px 12px; border-radius:999px;
                border:2px solid var(--border,#dbeafe);
                background:#fff; font-weight:900; color:var(--text-blue,#3b82f6);
                text-decoration:none;">
                {{ $page }}
              </a>
            @endif
          @endforeach
        @endif
      @endforeach

      {{-- Next --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="
          padding:8px 12px; border-radius:999px;
          border:2px solid var(--border,#dbeafe);
          background:#fff; font-weight:900; color:var(--text-blue,#3b82f6);
          text-decoration:none;">
          次へ ›
        </a>
      @else
        <span style="
          padding:8px 12px; border-radius:999px;
          border:2px solid var(--border,#dbeafe);
          background:#fff; opacity:.45; font-weight:900;">
          次へ ›
        </span>
      @endif

    </div>
  </nav>
@endif
