<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDriverInfoTable extends Migration {

	public function up()
	{
		Schema::create('driver_info', function(Blueprint $table) {
			$table->increments('id');
			$table->mediumInteger('org_code')->unsigned();
			$table->string('name', 50);
			$table->string('mobile_no', 20)->nullable();
            $table->string('image', 50)->nullable();
			$table->timestamps();
            $table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('driver_info');
	}
}
