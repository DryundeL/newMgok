<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokEvents5 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_events', function($table)
        {
            $table->string('class', 15)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_events', function($table)
        {
            $table->string('class', 15)->nullable(false)->change();
        });
    }
}
