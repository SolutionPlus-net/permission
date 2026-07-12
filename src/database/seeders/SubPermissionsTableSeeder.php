<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otas\Permission\Models\Permission;
use Otas\Permission\Models\SubPermission;
use Otas\Permission\Helpers\RouteInvestigator;

class SubPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $investigator = new RouteInvestigator();
        Permission::all()->each(function ($permission) use ($investigator) {
            $investigator->createSubPermissionsOf($permission)->each(function ($subPermission) {
                SubPermission::create([
                    'permission_id' => $subPermission['permission_id'],
                    'name' => $subPermission['name'],
                ])->translate([
                    'display_name' => $subPermission['display_name'],
                ], config('translatable.fallback_locale'));
            });
        });
    }
}
