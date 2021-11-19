<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokPersonalEvents extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_personal_events', function($table)
        {
            $table->string('login', 50)->change();
            $table->string('event_name', 50)->change();
            $table->string('event_place', 50)->change();
            $table->string('day_of_week', 20)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_personal_events', function($table)
        {
            $table->string('login', 191)->change();
            $table->string('event_name', 191)->change();
            $table->string('event_place', 191)->change();
            $table->string('day_of_week', 191)->change();
        });
    }
}
