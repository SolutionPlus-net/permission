<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Otas\Permission\Helpers\RouteInvestigator;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $investigator = new RouteInvestigator();
        $investigator->createPermissions()->map(function ($permission) {
            $permission->translate([
                'display_name' => $permission->name,
            ], config('translatable.fallback_locale'));
            return $permission->refresh();
        });
    }
}
