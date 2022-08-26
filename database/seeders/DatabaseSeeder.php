<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        $this->call(AreaSeeder::class);
        $this->call(BusinessUnitSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(FunctionalLocationSeeder::class);
        $this->call(InitialTestSeeder::class);
        $this->call(MaintenanceDocumentSeeder::class);
        $this->call(PhotoSeeder::class);
        $this->call(SettlementSeeder::class);
        $this->call(SettlementByBusinessUnitSeeder::class);
        $this->call(SubAreaSeeder::class);
        $this->call(SubCategorySeeder::class);
        $this->call(SurveySeeder::class);
        $this->call(SurveyPeriodSeeder::class);
        $this->call(SurveyResultSeeder::class);
        $this->call(UserSeeder::class);
    }
}
