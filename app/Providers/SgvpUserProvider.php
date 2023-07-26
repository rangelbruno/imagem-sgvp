<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Http;

class SgvpUserProvider implements UserProvider
{
    private $guard;

    public function __construct($guard)
    {
        $this->guard = $guard;
    }

    public function retrieveById($identifier)
    {
        // Não utilizado
    }

    public function retrieveByToken($identifier, $token)
    {
        // Não utilizado
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Não utilizado
    }

    public function retrieveByCredentials(array $credentials)
    {
        $response = Http::post('http://154.56.43.108:8080/api/usuarios/autenticar', $credentials);

        if (!$response->ok()) {
            return null;
        }

        $data = $response->json();

        return new SgvpUser($data['cpf'], $data['senha'], $data['role'], $data['jwt_token']);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $response = Http::post('http://154.56.43.108:8080/api/usuarios/autenticar', $credentials);

        return $response->ok();
    }
}
