@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-6">
    <h6 class="font-semibold mb-0 dark:text-white">Dashboard</h6>
    <ul class="flex items-center gap-[6px]">
        <li class="font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:text-primary-600">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
    </ul>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
    {{-- Total Books --}}
    <div class="card border-0 shadow-none">
        <div class="card-body p-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-primary-100 dark:bg-primary-600/25 text-primary-600 dark:text-primary-400 rounded-2xl flex justify-center items-center text-2xl">
                    <iconify-icon icon="mdi:book-open-page-variant-outline"></iconify-icon>
                </div>
                <div>
                    <span class="text-secondary-light text-sm font-medium mb-1">Total Books</span>
                    <h5 class="font-bold mb-0">{{ $stats['books'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Authors --}}
    <div class="card border-0 shadow-none">
        <div class="card-body p-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 rounded-2xl flex justify-center items-center text-2xl">
                    <iconify-icon icon="mdi:account-edit-outline"></iconify-icon>
                </div>
                <div>
                    <span class="text-secondary-light text-sm font-medium mb-1">Total Authors</span>
                    <h5 class="font-bold mb-0">{{ $stats['authors'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Publishers --}}
    <div class="card border-0 shadow-none">
        <div class="card-body p-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-warning-100 dark:bg-warning-600/25 text-warning-600 dark:text-warning-400 rounded-2xl flex justify-center items-center text-2xl">
                    <iconify-icon icon="mdi:office-building-outline"></iconify-icon>
                </div>
                <div>
                    <span class="text-secondary-light text-sm font-medium mb-1">Total Publishers</span>
                    <h5 class="font-bold mb-0">{{ $stats['publishers'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Users --}}
    <div class="card border-0 shadow-none">
        <div class="card-body p-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 rounded-2xl flex justify-center items-center text-2xl">
                    <iconify-icon icon="mdi:account-group-outline"></iconify-icon>
                </div>
                <div>
                    <span class="text-secondary-light text-sm font-medium mb-1">Total Users</span>
                    <h5 class="font-bold mb-0">{{ $stats['users'] ?? 0 }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Books --}}
<div class="card border-0 shadow-none">
    <div class="card-header flex items-center justify-between">
        <h5 class="text-lg font-semibold mb-0">Recent Books</h5>
        <a href="{{ route('books.index') }}" class="text-primary-600 text-sm font-medium hover:underline">View All</a>
    </div>
    <div class="card-body">
        <div class="overflow-x-auto">
            <table class="table bordered-table mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>ISBN</th>
                        <th>Published</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBooks as $book)
                    <tr>
                        <td>{{ $book['title'] }}</td>
                        <td>{{ $book['author']['name'] ?? '-' }}</td>
                        <td>{{ $book['publisher']['name'] ?? '-' }}</td>
                        <td><span class="text-xs font-mono">{{ $book['isbn'] }}</span></td>
                        <td>{{ $book['published_at'] ? \Carbon\Carbon::parse($book['published_at'])->format('d M Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary-light">No books found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
