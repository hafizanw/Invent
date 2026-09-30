<?php

namespace App\Models;

class UserModel extends BaseModel
{
    public ?int $id = null;
    public ?int $role_id = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function initialize()
    {
        parent::initialize();

        $this->setSource('users');

        // belongsTo didefinisikan di sisi yang menyimpan foreign key (users.role_id).
        // Parameter: (kolom lokal, Model tujuan, kolom di Model tujuan, opsi)
        $this->belongsTo(
            'role_id',
            RoleModel::class,
            'id',
            ['alias' => 'role']
        );
    }
}