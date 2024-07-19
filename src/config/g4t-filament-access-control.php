<?php


return [
    "models" => [
        "user" => App\Models\User::class,
        "role" => Spatie\Permission\Models\Role::class,
        "permission" => Spatie\Permission\Models\Permission::class,
    ],
    "titles" => [
        "role" => "Role",
        "roles" => "Roles",
        "permission" => "Permission",
        "permissions" => "Permissions",
        "user" => "User",
        "users" => "Users"
    ],
    "icons" => [
        "users" => "heroicon-o-users",
        "roles" => "heroicon-o-key",
        "permissions" => "heroicon-o-lock-closed",
    ]
];
