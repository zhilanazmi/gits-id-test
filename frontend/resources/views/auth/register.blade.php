@extends('layouts.auth')

@section('title', 'Sign Up')

@section('content')
<section class="bg-white dark:bg-dark-2 flex flex-wrap min-h-[100vh]">
    <div class="lg:w-1/2 lg:block hidden">
        <div class="flex items-center flex-col h-full justify-center">
            <img src="{{ asset('assets/images/auth/auth-img.png') }}" alt="">
        </div>
    </div>
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
        <div class="lg:max-w-[464px] mx-auto w-full">
            <div>
                <a href="{{ route('login') }}" class="mb-2.5 max-w-[290px]">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="">
                </a>
                <h4 class="mb-3">Create your Account</h4>
                <p class="mb-8 text-secondary-light text-lg">Please fill in the details to create your account</p>
            </div>

            @if($errors->any())
                <div class="bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 px-4 py-3 rounded-lg mb-4">
                    @foreach($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                        <iconify-icon icon="f7:person"></iconify-icon>
                    </span>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl" placeholder="Full Name" required>
                </div>
                <div class="icon-field mb-4 relative">
                    <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl" placeholder="Email" required>
                </div>
                <div class="relative mb-4">
                    <div class="icon-field">
                        <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span>
                        <input type="password" name="password" class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl" id="your-password" placeholder="Password" required>
                    </div>
                    <span class="toggle-password ri-eye-line cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light" data-toggle="#your-password"></span>
                </div>
                <div class="relative mb-5">
                    <div class="icon-field">
                        <span class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl">
                            <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                        </span>
                        <input type="password" name="password_confirmation" class="form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl" id="confirm-password" placeholder="Confirm Password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary justify-center text-sm btn-sm px-3 py-4 w-full rounded-xl mt-4">Sign Up</button>

                <div class="mt-8 text-center text-sm">
                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:underline">Sign In</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
