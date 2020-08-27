<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Department;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Department::create(['name' => 'JHS']);
        Department::create(['name' => 'ABM']);
        Department::create(['name' => 'GAS']);
        Department::create(['name' => 'HUMMS']);
        Department::create(['name' => 'STEM']);
        Department::create(['name' => 'BSA']);
        Department::create(['name' => 'BSBA']);
        Department::create(['name' => 'BSCS']);
        Department::create(['name' => 'BEED']);
        Department::create(['name' => 'CCJE']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
