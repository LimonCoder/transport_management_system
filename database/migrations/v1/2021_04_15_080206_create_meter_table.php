<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMeterTable extends Migration {

	public function up()
	{
		Schema::create('meter', function(Blueprint $table) {
			$table->increments('id');
			$table->mediumInteger('org_code')->unsigned();
			$table->integer('vehicle_id')->unsigned();
			$table->integer('log_book_id')->unsigned();
			$table->integer('out_km')->unsigned();
			$table->integer('in_km')->unsigned();
			$table->string('in_time',20)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('meter');
	}
}
