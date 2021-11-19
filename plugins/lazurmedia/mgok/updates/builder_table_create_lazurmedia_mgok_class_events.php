<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokClassEvents extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_class_events', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('teacher');
            $table->string('class');
            $table->string('event_name');
            $table->time('time_from');
            $table->time('time_to');
            $table->string('event_place');
            $table->string('day_of_week');
            $table->date('date');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_class_events');
    }
}
