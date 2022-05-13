<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokEvents6 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_events', function($table)
        {
            $table->string('day_of_week', 20)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_events', function($table)
        {
            $table->string('day_of_week', 20)->nullable(false)->change();
        });
    }
}
