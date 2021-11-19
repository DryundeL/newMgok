<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokSchedule extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_schedule', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('number_lesson')->unsigned();
            $table->string('lesson_name', 50);
            $table->time('time_from');
            $table->time('time_to');
            $table->integer('cabinet')->unsigned();
            $table->string('teacher', 30);
            $table->string('day_of_week', 15);
            $table->string('class', 10);
            $table->integer('parity')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_schedule');
    }
}
