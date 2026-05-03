<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerificationController extends Controller
{
    /**
     * Affiche la page demandant à l'utilisateur de vérifier son email.
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended('/layout')
            : view('auth.verify-email');
    }

    /**
     * Gère la vérification de l'email via le lien signé.
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->intended('/layout')->with('success', '✅ Votre email a été vérifié avec succès !');
    }

    /**
     * Renvoie l'email de vérification.
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', '✅ Un nouveau lien de vérification a été envoyé à votre adresse email.');
    }
}
