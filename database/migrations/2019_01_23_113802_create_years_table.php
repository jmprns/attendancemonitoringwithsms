<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Year;

class CreateYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('dept_id');
            $table->timestamps();
        });

        Year::create(['name' => 'Grade 7', 'dept_id' => '1']);
        Year::create(['name' => 'Grade 8', 'dept_id' => '1']);
        Year::create(['name' => 'Grade 9', 'dept_id' => '1']);
        Year::create(['name' => 'Grade 10', 'dept_id' => '1']);

        Year::create(['name' => 'Grade 11', 'dept_id' => '2']);
        Year::create(['name' => 'Grade 12', 'dept_id' => '2']);

        Year::create(['name' => 'Grade 11', 'dept_id' => '3']);
        Year::create(['name' => 'Grade 12', 'dept_id' => '3']);

        Year::create(['name' => 'Grade 11', 'dept_id' => '4']);
        Year::create(['name' => 'Grade 12', 'dept_id' => '4']);

        Year::create(['name' => 'Grade 11', 'dept_id' => '5']);
        Year::create(['name' => 'Grade 12', 'dept_id' => '5']);

        Year::create(['name' => 'First Year', 'dept_id' => '6']);
        Year::create(['name' => 'Second Year', 'dept_id' => '6']);
        Year::create(['name' => 'Third Year', 'dept_id' => '6']);
        Year::create(['name' => 'Fourth Year', 'dept_id' => '6']);

        Year::create(['name' => 'First Year', 'dept_id' => '7']);
        Year::create(['name' => 'Second Year', 'dept_id' => '7']);
        Year::create(['name' => 'Third Year', 'dept_id' => '7']);
        Year::create(['name' => 'Fourth Year', 'dept_id' => '7']);

        Year::create(['name' => 'First Year', 'dept_id' => '8']);
        Year::create(['name' => 'Second Year', 'dept_id' => '8']);
        Year::create(['name' => 'Third Year', 'dept_id' => '8']);
        Year::create(['name' => 'Fourth Year', 'dept_id' => '8']);

        Year::create(['name' => 'First Year', 'dept_id' => '9']);
        Year::create(['name' => 'Second Year', 'dept_id' => '9']);
        Year::create(['name' => 'Third Year', 'dept_id' => '9']);
        Year::create(['name' => 'Fourth Year', 'dept_id' => '9']);

        Year::create(['name' => 'First Year', 'dept_id' => '10']);
        Year::create(['name' => 'Second Year', 'dept_id' => '10']);
        Year::create(['name' => 'Third Year', 'dept_id' => '10']);
        Year::create(['name' => 'Fourth Year', 'dept_id' => '10']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('years');
    }
}
