@extends('layouts.app')

@section('title', 'Books')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-6">
    <h6 class="font-semibold mb-0 dark:text-white">Books</h6>
    <ul class="flex items-center gap-[6px]">
        <li class="font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:text-primary-600">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="font-medium">Books</li>
    </ul>
</div>

<div class="card border-0 shadow-none">
    <div class="card-header flex items-center justify-between flex-wrap gap-3">
        <h5 class="text-lg font-semibold mb-0">Books List</h5>
        <div class="flex items-center gap-3 flex-wrap">
            <form action="{{ route('books.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..." class="form-control form-control-sm rounded-lg">
                <select name="author_id" class="form-select form-select-sm rounded-lg">
                    <option value="">All Authors</option>
                    @foreach($authors as $author)
                        <option value="{{ $author['id'] }}" {{ request('author_id') == $author['id'] ? 'selected' : '' }}>{{ $author['name'] }}</option>
                    @endforeach
                </select>
                <select name="publisher_id" class="form-select form-select-sm rounded-lg">
                    <option value="">All Publishers</option>
                    @foreach($publishers as $publisher)
                        <option value="{{ $publisher['id'] }}" {{ request('publisher_id') == $publisher['id'] ? 'selected' : '' }}>{{ $publisher['name'] }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary-600 btn-sm">
                    <iconify-icon icon="ion:search-outline"></iconify-icon>
                </button>
            </form>
            <a href="{{ route('books.create') }}" class="btn btn-primary-600 btn-sm flex items-center gap-1">
                <iconify-icon icon="ic:baseline-plus"></iconify-icon>
                Add Book
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="overflow-x-auto">
            <table class="table bordered-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>ISBN</th>
                        <th>Pages</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                    <tr>
                        <td>{{ ($meta['current_page'] - 1) * $meta['per_page'] + $index + 1 }}</td>
                        <td><span class="font-medium">{{ $book['title'] }}</span></td>
                        <td>{{ $book['author']['name'] ?? '-' }}</td>
                        <td>{{ $book['publisher']['name'] ?? '-' }}</td>
                        <td><span class="text-xs font-mono">{{ $book['isbn'] }}</span></td>
                        <td>{{ $book['pages'] ?? '-' }}</td>
                        <td>{{ $book['published_at'] ? \Carbon\Carbon::parse($book['published_at'])->format('d M Y') : '-' }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('books.edit', $book['id']) }}" class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center" title="Edit">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <form action="{{ route('books.destroy', $book['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-full inline-flex items-center justify-center" title="Delete">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-secondary-light">No books found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($meta['last_page'] > 1)
        <div class="flex items-center justify-between mt-6">
            <span class="text-sm text-secondary-light">
                Showing {{ ($meta['current_page'] - 1) * $meta['per_page'] + 1 }} to {{ min($meta['current_page'] * $meta['per_page'], $meta['total']) }} of {{ $meta['total'] }} entries
            </span>
            <nav class="flex items-center gap-1">
                @if($meta['current_page'] > 1)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $meta['current_page'] - 1]) }}" class="w-9 h-9 rounded-lg flex items-center justify-center border hover:bg-primary-600 hover:text-white">
                        <iconify-icon icon="ep:arrow-left"></iconify-icon>
                    </a>
                @endif

                @for($i = 1; $i <= $meta['last_page']; $i++)
                    <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" class="w-9 h-9 rounded-lg flex items-center justify-center border {{ $i == $meta['current_page'] ? 'bg-primary-600 text-white' : 'hover:bg-primary-600 hover:text-white' }}">
                        {{ $i }}
                    </a>
                @endfor

                @if($meta['current_page'] < $meta['last_page'])
                    <a href="{{ request()->fullUrlWithQuery(['page' => $meta['current_page'] + 1]) }}" class="w-9 h-9 rounded-lg flex items-center justify-center border hover:bg-primary-600 hover:text-white">
                        <iconify-icon icon="ep:arrow-right"></iconify-icon>
                    </a>
                @endif
            </nav>
        </div>
        @endif
    </div>
</div>
@endsection
