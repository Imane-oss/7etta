@extends('layout')

@section('title', 'Vérifiez votre Email | 7ETTA')

@section('content')
<div class="auth-container py-12 px-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="auth-card" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); padding: 40px; max-width: 500px; width: 100%; text-align: center; border: 1px solid rgba(255,255,255,0.5);">
        
        <div class="icon-wrapper mb-6" style="background: #f0f7ff; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 17a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9.5C2 7 4 5 6.5 5H18c2.2 0 4 1.8 4 4v8Z"/><path d="m22 7-7.1 4.6c-1.8 1.2-4 1.2-5.8 0L2 7"/></svg>
        </div>

        <h1 class="text-3xl font-bold mb-4" style="color: #1a1a1a; font-family: 'Outfit', sans-serif;">Vérifiez votre email</h1>
        
        <p class="text-gray-600 mb-8" style="font-size: 1.1rem; line-height: 1.6;">
            Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ?
        </p>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full py-3 px-6 rounded-xl font-bold transition-all duration-300" style="background: #1a1a1a; color: white; border: none; cursor: pointer; font-size: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                    Renvoyer l'email de vérification
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2 text-gray-500 hover:text-black transition-colors font-medium underline" style="background: transparent; border: none; cursor: pointer;">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap');
    
    .auth-card {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.25) !important;
        background: #333 !important;
    }
</style>
@endsection
