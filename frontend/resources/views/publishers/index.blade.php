@extends('layouts.app')

@section('title', 'Publishers')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-6">
    <h6 class="font-semibold mb-0 dark:text-white">Publishers</h6>
    <ul class="flex items-center gap-[6px]">
        <li class="font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:text-primary-600">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="font-medium">Publishers</li>
    </ul>
</div>

<div class="card border-0 shadow-none">
    <div class="card-header flex items-center justify-between flex-wrap gap-3">
        <h5 class="text-lg font-semibold mb-0">Publishers List</h5>
        <div class="flex items-center gap-3 flex-wrap">
            <form action="{{ route('publishers.index') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search publishers..." class="form-control form-control-sm rounded-lg">
                <button type="submit" class="btn btn-primary-600 btn-sm">
                    <iconify-icon icon="ion:search-outline"></iconify-icon>
                </button>
            </form>
            <a href="{{ route('publishers.create') }}" class="btn btn-primary-600 btn-sm flex items-center gap-1">
                <iconify-icon icon="ic:baseline-plus"></iconify-icon>
                Add Publisher
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="overflow-x-auto">
            <table class="table bordered-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Books</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($publishers as $index => $publisher)
                    <tr>
                        <td>{{ ($meta['current_page'] - 1) * $meta['per_page'] + $index + 1 }}</td>
                        <td><span class="font-medium">{{ $publisher['name'] }}</span></td>
                        <td>{{ $publisher['email'] ?? '-' }}</td>
                        <td>{{ $publisher['phone'] ?? '-' }}</td>
                        <td>
                            <span class="bg-primary-100 dark:bg-primary-600/25 text-primary-600 dark:text-primary-400 px-3 py-1 rounded-full text-xs font-medium">
                                {{ $publisher['books_count'] ?? 0 }} books
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('publishers.edit', $publisher['id']) }}" class="w-8 h-8 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-full inline-flex items-center justify-center" title="Edit">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <form action="{{ route('publishers.destroy', $publisher['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this publisher?')">
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
                        <td colspan="6" class="text-center text-secondary-light">No publishers found</td>
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
