<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->mediumInteger('org_code')->nullable();
			$table->mediumInteger('employee_id')->nullable();
			$table->string('username', 50)->unique();
			$table->string('password', 255);
			$table->tinyInteger('type')->comment("1 = super_admin, 2 = admin, 3 = others");
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}
