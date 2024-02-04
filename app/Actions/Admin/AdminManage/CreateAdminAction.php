<?php

namespace App\Actions\Admin\AdminManage;

use App\Http\Traits\ImageUpload;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CreateAdminAction
{
    use ImageUpload;

    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data): User
    {
        $avatar = isset($data['avatar']) ? $this->createImage($data['avatar'], 'avatars/users') : null;

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'role' => 'admin',
            'avatar' => $avatar,
        ]);

        $role = Role::with('permissions')->where('id', $data['role_id'])->first();

        if ($role) {
            $user->assignRole($role->name);
            $user->syncPermissions($role->permissions);
        }

        return $user;
    }
}
