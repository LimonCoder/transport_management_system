<?php

use Illuminate\Database\Seeder;
use seeds\DesignationTableSeeder;

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
            DesignationTableSeeder::class,
            OrganizationsTableSeeder::class,
            FuelTypeTableSeeder::class,
            VehiclesTableSeeder::class,
            TripsTableSeeder::class,
            RoutesTableSeeder::class
        ]);
    }
}