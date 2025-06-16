<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizationInfoTable extends Migration {

	public function up()
	{
		Schema::create('organization_info', function(Blueprint $table) {
			$table->increments('id');
			$table->mediumInteger('org_code')->unique();
			$table->string('name', 50);
			$table->string('address', 60)->nullable();
			$table->mediumInteger('org_type');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('organization_info');
	}
}
