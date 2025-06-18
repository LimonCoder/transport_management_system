<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumInteger('org_code')->unique(); 
            $table->string('name', 100); 
            $table->string('address', 200)->nullable(); 
            $table->enum('org_type', ['university', 'college'])->default('university'); 
            $table->timestamps(); 
            $table->softDeletes(); 
            $table->index('org_code');
            $table->index('org_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
} 