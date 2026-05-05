@extends('layouts.app')

@section('title', isset($author) ? 'Edit Author' : 'Add Author')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-6">
    <h6 class="font-semibold mb-0 dark:text-white">{{ isset($author) ? 'Edit Author' : 'Add Author' }}</h6>
    <ul class="flex items-center gap-[6px]">
        <li class="font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:text-primary-600">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="font-medium"><a href="{{ route('authors.index') }}" class="hover:text-primary-600">Authors</a></li>
        <li>-</li>
        <li class="font-medium">{{ isset($author) ? 'Edit' : 'Add' }}</li>
    </ul>
</div>

<div class="card border-0 shadow-none">
    <div class="card-header">
        <h5 class="text-lg font-semibold mb-0">{{ isset($author) ? 'Edit Author' : 'Add New Author' }}</h5>
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

        <form action="{{ isset($author) ? route('authors.update', $author['id']) : route('authors.store') }}" method="POST">
            @csrf
            @if(isset($author))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="form-label">Name <span class="text-danger-600">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $author['name'] ?? '') }}" class="form-control" placeholder="Enter author name" required>
                </div>

                <div>
                    <label class="form-label">Birth Date</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', isset($author['birth_date']) ? \Carbon\Carbon::parse($author['birth_date'])->format('Y-m-d') : '') }}" class="form-control">
                </div>

                <div>
                    <label class="form-label">Bio</label>
                    <textarea name="bio" rows="5" class="form-control" placeholder="Enter author biography">{{ old('bio', $author['bio'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="btn btn-primary-600">
                    {{ isset($author) ? 'Update Author' : 'Create Author' }}
                </button>
                <a href="{{ route('authors.index') }}" class="btn btn-outline-neutral-600">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
