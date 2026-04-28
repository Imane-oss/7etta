@extends('layout')

@section('title', 'Forgot Password - 7ETTA')

@section('content')

<style>
    .auth-wrapper {
        background: linear-gradient(135deg, #e5e7eb 0%, #f3f4f6 100%);
        min-height: 80vh;
        display: flex;
        align-items: center;
        padding: 60px 0;
        font-family: 'Inter', sans-serif;
    }

    .auth-card-wrapper {
        position: relative;
        padding: 3px; /* Border thickness */
        border-radius: 20px;
        overflow: hidden;
        transform: translateY(30px);
        opacity: 0;
        animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    .auth-card-wrapper::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 150%;
        height: 150%;
        /* A premium trailing colorful gradient */
        background: conic-gradient(from 0deg, transparent 60%, #3b82f6, #8b5cf6, #ec4899, #f43f5e);
        transform: translate(-50%, -50%) rotate(0deg);
        animation: borderRotate 3s linear infinite;
        z-index: -1;
    }

    @keyframes borderRotate {
        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(16px);
        border-radius: 18px;
        height: 100%;
        width: 100%;
    }

    @keyframes fadeUp {
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .auth-card-body {
        padding: 3.5rem;
    }

    .auth-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.2rem;
        color: #111827;
        letter-spacing: -0.5px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 12px !important;
        padding: 14px 18px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        transition: all 0.3s ease;
        font-size: 15px;
        box-shadow: none !important;
    }

    .form-control:focus {
        border-color: #111827;
        box-shadow: 0 0 0 4px rgba(17, 24, 39, 0.05) !important;
        background: #fff;
    }

    .btn-dark {
        border-radius: 12px;
        padding: 14px;
        font-weight: 600;
        background: #111827;
        border: none;
        font-size: 16px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-dark::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }

    .btn-dark:hover::after {
        left: 100%;
    }

    .btn-dark:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(17, 24, 39, 0.2);
        background: #000;
    }

    .btn-dark:active {
        transform: translateY(0);
    }

    .auth-link {
        color: #4b5563;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .auth-link:hover {
        color: #111827;
        text-decoration: underline;
    }
</style>

<div class="auth-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card-wrapper">
                    <div class="auth-card">
                        <div class="auth-card-body">
                            <div class="text-center mb-5">
                                <h2 class="auth-title mb-3">Reset Password</h2>
                                <p class="text-muted" style="line-height: 1.6;">
                                    Forgot your password? No problem Just let us know your email address and we will email you a password reset link.
                                </p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger" style="border-radius: 12px;">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success" style="border-radius: 12px;">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                
                                <div class="mb-5">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                                </div>

                                <button type="submit" class="btn btn-dark w-100 mb-4">
                                    Email Password Reset Link
                                </button>
                                
                                <p class="text-center mt-4 text-muted mb-0">
                                    Remember your password? 
                                    <a href="{{ route('login') }}" class="auth-link">
                                        Sign In
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
