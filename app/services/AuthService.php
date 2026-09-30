<?php

namespace App\Services;

use App\Models\UserModel;
use Phalcon\Di\Injectable;

class AuthService extends Injectable
{
    /**
     * Coba login dengan email + password.
     * Return array data user kalau berhasil, null kalau gagal.
     */
    public function attempt(string $email, string $password): ?array
    {
        $user = UserModel::findFirst([
            'conditions' => 'email = :email:',
            'bind'       => ['email' => $email],
        ]);

        if (!$user) {
            return null;
        }

        // password_verify membandingkan password plaintext dengan hash tersimpan.
        // Kita TIDAK pernah decrypt hash -> hash bersifat satu arah.
        if (!password_verify($password, $user->password)) {
            return null;
        }

        $authData = [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'role'  => $user->role->name, // pakai relationship belongsTo dari Phase 3
        ];

        $this->session->set('auth', $authData);

        return $authData;
    }

    public function logout(): void
    {
        $this->session->remove('auth');
    }

    public function check(): bool
    {
        return $this->session->has('auth');
    }

    public function user(): ?array
    {
        return $this->session->get('auth');
    }
}