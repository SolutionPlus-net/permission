<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otas\Permission\Models\PermissionGroup;
use Otas\Permission\Models\PermissionGroupTranslation;

class PermissionGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroups = array_merge_recursive(
            config('permissions.default_permission_group'),
            config('permissions.additional_permission_groups')
        );

        $currentPermissionGroupsInTable = PermissionGroupTranslation::pluck('name')->flatten()->toArray();

        foreach ($permissionGroups['en'] as $index => $name) {
            if (!\in_array($name, $currentPermissionGroupsInTable)) {
                $permissionGroup = PermissionGroup::create([]);

                $permissionGroup->translations()->create([
                    'name' => $name,
                    'locale' => 'en',
                ]);

                if (isset($permissionGroups['ar'][$index])) {
                    $permissionGroup->translations()->create([
                        'name' => $permissionGroups['ar'][$index],
                        'locale' => 'ar',
                    ]);
                }
            }
        }
    }
}
