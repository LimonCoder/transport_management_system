<?php

use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('notices')->insert([
            [
                'org_code' => 1001,
                'title' => 'Notice 1',
                'details' => 'This is the first test notice.',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'org_code' => 1001,
                'title' => 'Notice 2',
                'details' => 'This is the second test notice.',
                'status' => 'inactive',
                'created_by' => 2,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'org_code' => 1002,
                'title' => 'Notice 3',
                'details' => 'This is the third test notice.',
                'status' => 'active',
                'created_by' => 1,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
        ]);
    }
}
