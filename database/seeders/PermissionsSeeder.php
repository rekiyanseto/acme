<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list areas']);
        Permission::create(['name' => 'view areas']);
        Permission::create(['name' => 'create areas']);
        Permission::create(['name' => 'update areas']);
        Permission::create(['name' => 'delete areas']);

        Permission::create(['name' => 'list businessunits']);
        Permission::create(['name' => 'view businessunits']);
        Permission::create(['name' => 'create businessunits']);
        Permission::create(['name' => 'update businessunits']);
        Permission::create(['name' => 'delete businessunits']);

        Permission::create(['name' => 'list categories']);
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

        Permission::create(['name' => 'list companies']);
        Permission::create(['name' => 'view companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'update companies']);
        Permission::create(['name' => 'delete companies']);

        Permission::create(['name' => 'list equipments']);
        Permission::create(['name' => 'view equipments']);
        Permission::create(['name' => 'create equipments']);
        Permission::create(['name' => 'update equipments']);
        Permission::create(['name' => 'delete equipments']);

        Permission::create(['name' => 'list functionallocations']);
        Permission::create(['name' => 'view functionallocations']);
        Permission::create(['name' => 'create functionallocations']);
        Permission::create(['name' => 'update functionallocations']);
        Permission::create(['name' => 'delete functionallocations']);

        Permission::create(['name' => 'list initialtests']);
        Permission::create(['name' => 'view initialtests']);
        Permission::create(['name' => 'create initialtests']);
        Permission::create(['name' => 'update initialtests']);
        Permission::create(['name' => 'delete initialtests']);

        Permission::create(['name' => 'list maintenancedocuments']);
        Permission::create(['name' => 'view maintenancedocuments']);
        Permission::create(['name' => 'create maintenancedocuments']);
        Permission::create(['name' => 'update maintenancedocuments']);
        Permission::create(['name' => 'delete maintenancedocuments']);

        Permission::create(['name' => 'list photos']);
        Permission::create(['name' => 'view photos']);
        Permission::create(['name' => 'create photos']);
        Permission::create(['name' => 'update photos']);
        Permission::create(['name' => 'delete photos']);

        Permission::create(['name' => 'list settlements']);
        Permission::create(['name' => 'view settlements']);
        Permission::create(['name' => 'create settlements']);
        Permission::create(['name' => 'update settlements']);
        Permission::create(['name' => 'delete settlements']);

        Permission::create(['name' => 'list settlementbybusinessunits']);
        Permission::create(['name' => 'view settlementbybusinessunits']);
        Permission::create(['name' => 'create settlementbybusinessunits']);
        Permission::create(['name' => 'update settlementbybusinessunits']);
        Permission::create(['name' => 'delete settlementbybusinessunits']);

        Permission::create(['name' => 'list subareas']);
        Permission::create(['name' => 'view subareas']);
        Permission::create(['name' => 'create subareas']);
        Permission::create(['name' => 'update subareas']);
        Permission::create(['name' => 'delete subareas']);

        Permission::create(['name' => 'list subcategories']);
        Permission::create(['name' => 'view subcategories']);
        Permission::create(['name' => 'create subcategories']);
        Permission::create(['name' => 'update subcategories']);
        Permission::create(['name' => 'delete subcategories']);

        Permission::create(['name' => 'list surveys']);
        Permission::create(['name' => 'view surveys']);
        Permission::create(['name' => 'create surveys']);
        Permission::create(['name' => 'update surveys']);
        Permission::create(['name' => 'delete surveys']);

        Permission::create(['name' => 'list surveyperiods']);
        Permission::create(['name' => 'view surveyperiods']);
        Permission::create(['name' => 'create surveyperiods']);
        Permission::create(['name' => 'update surveyperiods']);
        Permission::create(['name' => 'delete surveyperiods']);

        Permission::create(['name' => 'list surveyresults']);
        Permission::create(['name' => 'view surveyresults']);
        Permission::create(['name' => 'create surveyresults']);
        Permission::create(['name' => 'update surveyresults']);
        Permission::create(['name' => 'delete surveyresults']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}
