<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'management_kostum_access',
            ],
            [
                'id'    => 18,
                'title' => 'category_create',
            ],
            [
                'id'    => 19,
                'title' => 'category_edit',
            ],
            [
                'id'    => 20,
                'title' => 'category_show',
            ],
            [
                'id'    => 21,
                'title' => 'category_delete',
            ],
            [
                'id'    => 22,
                'title' => 'category_access',
            ],
            [
                'id'    => 23,
                'title' => 'kostum_create',
            ],
            [
                'id'    => 24,
                'title' => 'kostum_edit',
            ],
            [
                'id'    => 25,
                'title' => 'kostum_show',
            ],
            [
                'id'    => 26,
                'title' => 'kostum_delete',
            ],
            [
                'id'    => 27,
                'title' => 'kostum_access',
            ],
            [
                'id'    => 28,
                'title' => 'productschedule_create',
            ],
            [
                'id'    => 29,
                'title' => 'productschedule_edit',
            ],
            [
                'id'    => 30,
                'title' => 'productschedule_show',
            ],
            [
                'id'    => 31,
                'title' => 'productschedule_delete',
            ],
            [
                'id'    => 32,
                'title' => 'productschedule_access',
            ],
            [
                'id'    => 34,
                'title' => 'management_order_access',
            ],
            [
                'id'    => 35,
                'title' => 'order_create',
            ],
            [
                'id'    => 36,
                'title' => 'order_edit',
            ],
            [
                'id'    => 37,
                'title' => 'order_show',
            ],
            [
                'id'    => 38,
                'title' => 'order_delete',
            ],
            [
                'id'    => 39,
                'title' => 'order_access',
            ],
            [
                'id'    => 40,
                'title' => 'order_item_create',
            ],
            [
                'id'    => 41,
                'title' => 'order_item_edit',
            ],
            [
                'id'    => 42,
                'title' => 'order_item_show',
            ],
            [
                'id'    => 43,
                'title' => 'order_item_delete',
            ],
            [
                'id'    => 44,
                'title' => 'order_item_access',
            ],
            [
                'id'    => 45,
                'title' => 'management_history_access',
            ],
            [
                'id'    => 46,
                'title' => 'pengembalian_create',
            ],
            [
                'id'    => 47,
                'title' => 'pengembalian_edit',
            ],
            [
                'id'    => 48,
                'title' => 'pengembalian_show',
            ],
            [
                'id'    => 49,
                'title' => 'pengembalian_delete',
            ],
            [
                'id'    => 50,
                'title' => 'pengembalian_access',
            ],
            [
                'id'    => 51,
                'title' => 'history_order_create',
            ],
            [
                'id'    => 52,
                'title' => 'history_order_edit',
            ],
            [
                'id'    => 53,
                'title' => 'history_order_show',
            ],
            [
                'id'    => 54,
                'title' => 'history_order_delete',
            ],
            [
                'id'    => 55,
                'title' => 'history_order_access',
            ],
            [
                'id'    => 61,
                'title' => 'profile_create',
            ],
            [
                'id'    => 62,
                'title' => 'profile_edit',
            ],
            [
                'id'    => 63,
                'title' => 'profile_show',
            ],
            [
                'id'    => 64,
                'title' => 'profile_delete',
            ],
            [
                'id'    => 65,
                'title' => 'profile_access',
            ],
            [
                'id'    => 66,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
