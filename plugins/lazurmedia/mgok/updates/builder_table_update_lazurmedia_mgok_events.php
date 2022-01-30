<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokEvents extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_events', function($table)
        {
            $table->string('creator', 30)->change();
            $table->boolean('event_class')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_events', function($table)
        {
            $table->string('creator', 50)->change();
            $table->boolean('event_class')->default(null)->change();
        });
    }
}
