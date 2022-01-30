<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokEvents extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_events', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('login', 50);
            $table->string('event_name', 50);
            $table->time('time_from');
            $table->time('time_to');
            $table->string('event_place', 50);
            $table->string('day_of_week', 20);
            $table->date('date');
            $table->string('creator', 50);
            $table->boolean('event_class');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_events');
    }
}
