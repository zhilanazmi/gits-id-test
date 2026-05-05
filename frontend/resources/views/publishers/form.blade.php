@extends('layouts.app')

@section('title', isset($publisher) ? 'Edit Publisher' : 'Add Publisher')

@section('content')
<div class="flex flex-wrap items-center justify-between gap-2 mb-6">
    <h6 class="font-semibold mb-0 dark:text-white">{{ isset($publisher) ? 'Edit Publisher' : 'Add Publisher' }}</h6>
    <ul class="flex items-center gap-[6px]">
        <li class="font-medium">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 hover:text-primary-600">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="font-medium"><a href="{{ route('publishers.index') }}" class="hover:text-primary-600">Publishers</a></li>
        <li>-</li>
        <li class="font-medium">{{ isset($publisher) ? 'Edit' : 'Add' }}</li>
    </ul>
</div>

<div class="card border-0 shadow-none">
    <div class="card-header">
        <h5 class="text-lg font-semibold mb-0">{{ isset($publisher) ? 'Edit Publisher' : 'Add New Publisher' }}</h5>
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

        <form action="{{ isset($publisher) ? route('publishers.update', $publisher['id']) : route('publishers.store') }}" method="POST">
            @csrf
            @if(isset($publisher))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="form-label">Name <span class="text-danger-600">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $publisher['name'] ?? '') }}" class="form-control" placeholder="Enter publisher name" required>
                </div>

                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $publisher['email'] ?? '') }}" class="form-control" placeholder="Enter email">
                </div>

                <div>
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $publisher['phone'] ?? '') }}" class="form-control" placeholder="Enter phone number">
                </div>

                <div class="md:col-span-2">
                    <label class="form-label">Address</label>
                    <textarea name="address" rows="3" class="form-control" placeholder="Enter address">{{ old('address', $publisher['address'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6">
                <button type="submit" class="btn btn-primary-600">
                    {{ isset($publisher) ? 'Update Publisher' : 'Create Publisher' }}
                </button>
                <a href="{{ route('publishers.index') }}" class="btn btn-outline-neutral-600">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
