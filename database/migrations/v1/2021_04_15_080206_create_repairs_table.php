<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRepairsTable extends Migration {

	public function up()
	{
		Schema::create('repairs', function(Blueprint $table) {
			$table->increments('id');
            $table->mediumInteger('org_code')->unsigned();
			$table->integer('vehicle_id')->unsigned();
			$table->integer('employee_id')->unsigned();
			$table->string('damage_parts', 100)->nullable();
			$table->string('new_parts', 100)->nullable();
			$table->decimal('total_cost', 10,2)->nullable();
			$table->string('cause_of_problems', 255)->nullable();
			$table->date('insert_date');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	public function down()
	{
		Schema::drop('repairs');
	}
}
