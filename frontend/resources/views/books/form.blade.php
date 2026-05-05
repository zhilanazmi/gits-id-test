@extends('layouts.app')

@section('title', isset($book) ? 'Edit Book' : 'Add Book')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-6">
    <h6 class="font-semibold mb-0 dark:text-white">{{ isset($book) ? 'Edit Book' : 'Add Book' }}</h6>
    <ul class="flex items-center gap-[6px]">
        <li class="font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:text-primary-600">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="font-medium"><a href="{{ route('books.index') }}" class="hover:text-primary-600">Books</a></li>
        <li>-</li>
        <li class="font-medium">{{ isset($book) ? 'Edit' : 'Add' }}</li>
    </ul>
</div>

<div class="card border-0 shadow-none">
    <div class="card-header">
        <h5 class="text-lg font-semibold mb-0">{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</h5>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 px-4 py-3 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($book) ? route('books.update', $book['id']) : route('books.store') }}" method="POST">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="form-label">Title <span class="text-danger-600">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $book['title'] ?? '') }}" class="form-control" placeholder="Enter book title" required>
                </div>

                <div>
                    <label class="form-label">Author <span class="text-danger-600">*</span></label>
                    <select name="author_id" class="form-select" required>
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                            <option value="{{ $author['id'] }}" {{ old('author_id', $book['author_id'] ?? '') == $author['id'] ? 'selected' : '' }}>
                                {{ $author['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Publisher <span class="text-danger-600">*</span></label>
                    <select name="publisher_id" class="form-select" required>
                        <option value="">Select Publisher</option>
                        @foreach($publishers as $publisher)
                            <option value="{{ $publisher['id'] }}" {{ old('publisher_id', $book['publisher_id'] ?? '') == $publisher['id'] ? 'selected' : '' }}>
                                {{ $publisher['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">ISBN <span class="text-danger-600">*</span></label>
                    <input type="text" name="isbn" value="{{ old('isbn', $book['isbn'] ?? '') }}" class="form-control" placeholder="Enter ISBN" required>
                </div>

                <div>
                    <label class="form-label">Pages</label>
                    <input type="number" name="pages" value="{{ old('pages', $book['pages'] ?? '') }}" class="form-control" placeholder="Number of pages" min="1">
                </div>

                <div>
                    <label class="form-label">Published Date</label>
                    <input type="date" name="published_at" value="{{ old('published_at', isset($book['published_at']) ? \Carbon\Carbon::parse($book['published_at'])->format('Y-m-d') : '') }}" class="form-control">
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="5" class="form-control" placeholder="Enter book description">{{ old('description', $book['description'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="btn btn-primary-600">
                    {{ isset($book) ? 'Update Book' : 'Create Book' }}
                </button>
                <a href="{{ route('books.index') }}" class="btn btn-outline-neutral-600">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
