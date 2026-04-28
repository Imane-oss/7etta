@extends('layout')

@section('title', 'Contact Us - 7ETTA')

@section('content')

<style>
    /* =========================================
       PAGE BACKGROUND
    ========================================= */
    .contact-page {
        background: #f0f2f5;
        min-height: 100vh;
        padding: 70px 0 90px;
        font-family: 'Inter', sans-serif;
    }

    /* =========================================
       PAGE HEADER
    ========================================= */
    .contact-page-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .contact-page-header h1 {
        font-size: 2.6rem;
        font-weight: 700;
        color: #1a1a2e;
        letter-spacing: -0.5px;
        margin-bottom: 14px;
    }

    .contact-page-header p {
        font-size: 1.05rem;
        color: #6b7280;
        font-weight: 400;
        margin: 0;
    }

    /* =========================================
       MAIN CARD WRAPPER
    ========================================= */
    .contact-card-wrapper {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08), 0 2px 12px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        max-width: 960px;
        margin: 0 auto;
    }

    /* =========================================
       LEFT PANEL — FORM
    ========================================= */
    .contact-form-panel {
        padding: 48px 44px;
        border-right: 1px solid #f1f1f1;
    }

    .contact-form-panel h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 28px;
        letter-spacing: -0.2px;
    }

    /* Labels */
    .contact-form-panel .form-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #6b7280;
        margin-bottom: 7px;
    }

    /* Inputs */
    .contact-form-panel .form-control {
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.92rem;
        color: #1f2937;
        background: #fafafa;
        transition: border-color 0.22s ease, background 0.22s ease, box-shadow 0.22s ease;
    }

    .contact-form-panel .form-control::placeholder {
        color: #c4c9d4;
    }

    .contact-form-panel .form-control:focus {
        border-color: #6c63ff;
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.1);
        outline: none;
    }

    .contact-form-panel .form-control.is-invalid {
        border-color: #ef4444;
        background: #fff8f8;
    }

    .contact-form-panel .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    /* Textarea */
    .contact-form-panel textarea.form-control {
        resize: none;
        min-height: 130px;
    }

    /* Error text */
    .contact-form-panel .invalid-feedback {
        font-size: 0.8rem;
        margin-top: 5px;
        color: #ef4444;
    }

    /* =========================================
       SUBMIT BUTTON
    ========================================= */
    .btn-send {
        background: linear-gradient(135deg, #6c63ff 0%, #5a55e8 100%);
        color: #ffffff;
        border: none;
        border-radius: 10px;
        padding: 13px 30px;
        font-size: 0.92rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-send:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(108, 99, 255, 0.35);
        color: #fff;
    }

    .btn-send:active:not(:disabled) {
        transform: translateY(0px);
        box-shadow: 0 3px 10px rgba(108, 99, 255, 0.25);
    }

    .btn-send:disabled {
        opacity: 0.72;
        cursor: not-allowed;
    }

    /* Spinner inside button */
    .btn-send .spinner-border {
        width: 15px;
        height: 15px;
        border-width: 2px;
    }

    /* =========================================
       ALERTS
    ========================================= */
    .contact-alert-success {
        background: linear-gradient(135deg, #ecfdf5, #d1fae5);
        border: 1.5px solid #6ee7b7;
        border-radius: 12px;
        padding: 14px 18px;
        color: #065f46;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
    }

    .contact-alert-error {
        background: linear-gradient(135deg, #fff8f8, #fee2e2);
        border: 1.5px solid #fca5a5;
        border-radius: 12px;
        padding: 14px 18px;
        color: #991b1b;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 24px;
    }

    .contact-alert-error ul {
        margin: 0;
        padding-left: 16px;
    }

    /* =========================================
       RIGHT PANEL — CONTACT INFO
    ========================================= */
    .contact-info-panel {
        padding: 48px 38px;
        background: #f9fafb;
    }

    .contact-info-panel h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 12px;
        letter-spacing: -0.2px;
    }

    .contact-info-panel .info-subtitle {
        font-size: 0.88rem;
        color: #9ca3af;
        line-height: 1.6;
        margin-bottom: 36px;
    }

    /* Info Items */
    .contact-info-item {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        padding: 20px 0;
        border-bottom: 1px solid #f1f1f1;
        transition: transform 0.2s ease;
    }

    .contact-info-item:last-child {
        border-bottom: none;
    }

    .contact-info-item:hover {
        transform: translateX(4px);
    }

    .contact-info-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: linear-gradient(135deg, #ede9ff, #ddd6fe);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .contact-info-icon i {
        font-size: 1.1rem;
        color: #6c63ff;
    }

    .contact-info-text .info-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #9ca3af;
        margin-bottom: 3px;
    }

    .contact-info-text .info-value {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1f2937;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .contact-info-text .info-value:hover {
        color: #6c63ff;
    }

    /* =========================================
       AVAILABILITY BADGE
    ========================================= */
    .availability-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #ecfdf5;
        border: 1px solid #6ee7b7;
        color: #065f46;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 99px;
        margin-top: 40px;
    }

    .availability-badge .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
        animation: pulse-dot 1.6s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.5; transform: scale(0.7); }
    }

    /* =========================================
       RESPONSIVE
    ========================================= */
    @media (max-width: 768px) {
        .contact-page {
            padding: 40px 0 60px;
        }

        .contact-form-panel {
            padding: 36px 28px;
            border-right: none;
            border-bottom: 1px solid #f1f1f1;
        }

        .contact-info-panel {
            padding: 36px 28px;
        }

        .contact-page-header h1 {
            font-size: 2rem;
        }
    }
</style>

<section class="contact-page">
    <div class="container px-3">

        {{-- ====== PAGE HEADER ====== --}}
        <div class="contact-page-header">
            <h1>Contact Us</h1>
            <p>Have a question? We would love to hear from you.</p>
        </div>

        {{-- ====== MAIN CARD ====== --}}
        <div class="contact-card-wrapper">
            <div class="row g-0">

                {{-- ====== LEFT: FORM ====== --}}
                <div class="col-md-7">
                    <div class="contact-form-panel">
                        <h2>Send us a message</h2>

                        {{-- Success Alert --}}
                        @if(session('success'))
                            <div class="contact-alert-success">
                                <i class="bi bi-check-circle-fill fs-5"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        {{-- Error Alert --}}
                        @if(session('error'))
                            <div class="contact-alert-error">
                                <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0"></i>
                                <span>{{ session('error') }}</span>
                            </div>
                        @endif

                        {{-- Validation Errors Summary --}}
                        @if($errors->any())
                            <div class="contact-alert-error">
                                <i class="bi bi-exclamation-circle-fill fs-5 flex-shrink-0"></i>
                                <div>
                                    <strong>Please fix the following errors:</strong>
                                    <ul class="mt-1 mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        {{-- FORM --}}
                        <form method="POST" action="{{ route('contact.send') }}" id="contactForm" novalidate>
                            @csrf

                            {{-- Row: Name + Email --}}
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="John Doe"
                                        value="{{ old('name') }}"
                                        autocomplete="name"
                                    >
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="john@example.com"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                    >
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Subject --}}
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    class="form-control @error('subject') is-invalid @enderror"
                                    placeholder="How can we help you?"
                                    value="{{ old('subject') }}"
                                >
                                @error('subject')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Message --}}
                            <div class="mb-4">
                                <label for="message" class="form-label">Message</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    class="form-control @error('message') is-invalid @enderror"
                                    placeholder="Write your message here..."
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="btn-send" id="submitBtn">
                                <i class="bi bi-send" id="sendIcon"></i>
                                <span id="btnText">Send Message</span>
                                <span class="spinner-border d-none" id="spinner" role="status" aria-hidden="true"></span>
                            </button>

                        </form>
                    </div>
                </div>

                {{-- ====== RIGHT: CONTACT INFO ====== --}}
                <div class="col-md-5">
                    <div class="contact-info-panel">
                        <h2>Contact Information</h2>
                        <p class="info-subtitle">
                            Our support team is here to help you. We typically respond within 24 business hours.
                        </p>

                        {{-- Email --}}
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div class="contact-info-text">
                                <p class="info-label">Email Us</p>
                                <a href="mailto:7etta26@gmail.com" class="info-value">7etta26@gmail.com</a>
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="contact-info-text">
                                <p class="info-label">Call Us</p>
                                <a href="tel:+212603471552" class="info-value">+212 603 471 552</a>
                            </div>
                        </div>

                        {{-- Availability Badge --}}
                        <div class="availability-badge">
                            <span class="dot"></span>
                            Available Mon – Fri, 9:00 AM to 6:00 PM
                        </div>

                    </div>
                </div>

            </div>{{-- /row --}}
        </div>{{-- /card-wrapper --}}

    </div>
</section>

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function () {
        const btn    = document.getElementById('submitBtn');
        const text   = document.getElementById('btnText');
        const icon   = document.getElementById('sendIcon');
        const spinner = document.getElementById('spinner');

        btn.disabled = true;
        text.textContent = 'Sending...';
        icon.classList.add('d-none');
        spinner.classList.remove('d-none');
    });
</script>
@endpush

@endsection
