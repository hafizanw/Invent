<?php
namespace App\Models;

class RoleModel extends BaseModel
{
    public ?int $id            = null;
    public ?string $name       = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function initialize()
    {
        parent::initialize();

        $this->setSource('roles');

        $this->hasMany(
            'id',
            UserModel::class,
            'role_id',
            ['alias' => 'users']
        );
    }
}
