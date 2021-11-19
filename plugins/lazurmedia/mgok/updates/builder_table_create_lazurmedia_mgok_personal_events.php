<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokPersonalEvents extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_personal_events', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('login');
            $table->string('event_name');
            $table->time('time_from');
            $table->time('time_to');
            $table->string('event_place');
            $table->string('day_of_week');
            $table->date('date');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_personal_events');
    }
}
