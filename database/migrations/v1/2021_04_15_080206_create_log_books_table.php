<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogBooksTable extends Migration {

	public function up()
	{
		Schema::create('log_books', function(Blueprint $table) {
			$table->increments('id');
			$table->mediumInteger('org_code')->unsigned();
			$table->integer('driver_id')->unsigned();
			$table->integer('vehicle_id')->unsigned();
			$table->mediumInteger('employee_id')->unsigned();
			$table->string('from', 100);
			$table->string('out_time',20);
			$table->string('destination', 100);
			$table->string('journey_time',20);
			$table->string('journey_cause', 100)->nullable();
			$table->date('insert_date');
			$table->tinyInteger('status')->comment("1 = complete, 0 = incomplete");
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('log_books');
	}
}
