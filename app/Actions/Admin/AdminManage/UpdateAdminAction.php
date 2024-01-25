<?php

namespace App\Actions\Admin\AdminManage;

use App\Http\Traits\ImageUpload;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UpdateAdminAction
{
    use ImageUpload;

    /**
     * @param  array<mixed>  $data
     */
    public function handle(array $data, User $user): User
    {
        $avatar = isset($data['avatar']) && ! is_string($data['avatar']) ? $this->updateImage($data['avatar'], $user->avatar, 'avatars/users') : $user->avatar;

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'] ?? $user->password,
            'role' => 'admin',
            'avatar' => $avatar,
        ]);

        $user->roles()->detach();

        $user->permissions()->detach();

        $role = Role::with('permissions')->where('id', $data['role_id'])->first();

        if ($role) {
            $user->assignRole($role->name);
            $user->syncPermissions($role->permissions);
        }

        return $user;
    }
}
