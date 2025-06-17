<?php

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
        # call all seeders
        $this->call([
            UsersTableSeeder::class,
            OperatorsTableSeeder::class,
            DriversTableSeeder::class,
            OrganizationsTableSeeder::class,
            FuelTypeTableSeeder::class,
            VehiclesTableSeeder::class,
            VehiclesAuditLogTableSeeder::class,
            TripsTableSeeder::class,
            TripsAuditLogTableSeeder::class,
        ]);
    }
}