<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokClassEvents4 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->dropColumn('time_from');
            $table->dropColumn('time_to');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->time('time_from');
            $table->time('time_to');
        });
    }
}
