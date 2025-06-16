<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehicleSetupTable extends Migration {

	public function up()
	{
		Schema::create('vehicle_setup', function(Blueprint $table) {
			$table->increments('id');
			$table->mediumInteger('org_code')->unsigned();
			$table->integer('employee_id')->unsigned();
			$table->integer('driver_id')->unsigned();
			$table->string('vehicle_reg_no', 20)->unique();
			$table->string('body_type', 30)->nullable();
			$table->string('chassis_no', 30)->nullable();
			$table->string('engine_no', 30)->nullable();
			$table->string('develop_year', 10)->nullable();
			$table->string('fitness_duration', 50)->nullable();
			$table->string('tax_token_duration', 50)->nullable();
			$table->date('assignment_date')->nullable();
			$table->text('images')->nullable();
			$table->date('useless_date')->nullable();
			$table->tinyInteger('status')->unsigned()->comment("1 = running, 0 = useless");
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('vehicle_setup');
	}
}
