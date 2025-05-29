@if ($paginator->hasPages())
<nav role="navigation" class="flex items-center justify-between">
    {{-- Showing x to y of z results --}}
    <div class="text-sm">
        Showing
        @if ($paginator->firstItem())
        <span class="font-medium">{{ $paginator->firstItem() }}</span>
        to
        <span class="font-medium">{{ $paginator->lastItem() }}</span>
        @else
        {{ $paginator->count() }}
        @endif
        of
        <span class="font-medium">{{ $paginator->total() }}</span>
        results
    </div>

    {{-- Pagination controls --}}
    <div class="flex space-x-1 bg-[#2c2c2c] px-2 py-1 rounded-md">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <span class="px-2 py-1 text-gray-500 cursor-not-allowed">&lt;</span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-2 py-1 text-gray-300 hover:text-white">&lt;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        @if (is_string($element))
        <span class="px-2 py-1 text-gray-400">{{ $element }}</span>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <span class="px-3 py-1 dark:bg-white bg-black dark:text-black text-white rounded-md">{{ $page }}</span>
        @else
        <a href="{{ $url }}" class="px-3 py-1 text-gray-300 hover:text-white">{{ $page }}</a>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-2 py-1 text-gray-300 hover:text-white">&gt;</a>
        @else
        <span class="px-2 py-1 text-gray-500 cursor-not-allowed">&gt;</span>
        @endif
    </div>
</nav>
@endif
