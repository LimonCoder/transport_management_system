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
        $this->call(OrganizationInfoTableSeeder::class);
        $this->command->info("OrganizationInfo table seeded");

        $this->call(DesignationTableSeeder::class);
        $this->command->info("Designation table seeded");

        $this->call(EmployeeTableSeeder::class);
        $this->command->info("Employees table seeded");

        $this->call(UserTableSeeder::class);
        $this->command->info("User table seeded");

        $this->call(DriverInfoTableSeeder::class);
        $this->command->info("DriverInfo table seeded");

        $this->call(VehicleSetupTableSeeder::class);
        $this->command->info("VehicleSetup table seeded");

        $this->call(LogBookTableSeeder::class);
        $this->command->info("logBooks table seeded");

        $this->call(FuelOilTableSeeder::class);
        $this->command->info("FuelOil table seeded");

        $this->call(MeterTableSeeder::class);
        $this->command->info("Meter table seeded");

        $this->call(RepairsTableSeeder::class);
        $this->command->info("Repairs table seeded");

    }
}
