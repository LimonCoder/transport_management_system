<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeesTable extends Migration {

	public function up()
	{
		Schema::create('employees', function(Blueprint $table) {
			$table->increments('id');
			$table->mediumInteger('org_code')->unsigned();
			$table->mediumInteger('designation_id')->unsigned();
			$table->string('name', 50);
			$table->string('mobile_no', 20)->nullable();
			$table->string('email', 50)->nullable();
			$table->string('image', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('employees');
	}
}
