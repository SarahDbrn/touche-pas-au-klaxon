<?php
declare(strict_types=1);

class AuthController extends Controller
{
    public function login(): void
    {
        $this->render('auth/login', [
            'title' => 'Connexion',
            'errors' => [],
        ]);
    }
}
