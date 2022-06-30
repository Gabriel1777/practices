<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'role',
    ];

    public function includeRole(User $user)
    {
        $role = $user->role;
        if ($role)
            return $this->item($role, new RoleTransformer());
    }
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id, 
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role_id' => $user->role_id,
        ];
    }
}
