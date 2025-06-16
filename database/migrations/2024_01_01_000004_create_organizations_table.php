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
            $table->bigIncrements('id'); // Auto-incrementing unsigned big integer ID
            $table->mediumInteger('org_code')->unique(); // Unique organization code
            $table->string('name', 50); // Organization name
            $table->string('address', 60)->nullable(); // Organization address
            $table->enum('org_type', ['university', 'college'])->default('university'); 
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // deleted_at for soft deletes
            
            // Add indexes for better performance
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