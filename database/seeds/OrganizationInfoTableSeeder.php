<?php

use Illuminate\Database\Seeder;
use App\Models\OrganizationInfo;

class OrganizationInfoTableSeeder extends Seeder {

	public function run()
	{
		//DB::table('organization_info')->delete();

		// 1 = row
		OrganizationInfo::create([
				'org_code' => 369949,
				'name' => 'কুমিল্লা-জেলা-কার্যালয়',
				'address' => 'কুমিল্লা',
				'org_type' => 1
			]);
	}
}
