<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokClassEvents extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->string('teacher', 50)->change();
            $table->string('class', 30)->change();
            $table->string('event_name', 50)->change();
            $table->string('event_place', 50)->change();
            $table->string('day_of_week', 20)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->string('teacher', 191)->change();
            $table->string('class', 191)->change();
            $table->string('event_name', 191)->change();
            $table->string('event_place', 191)->change();
            $table->string('day_of_week', 191)->change();
        });
    }
}
