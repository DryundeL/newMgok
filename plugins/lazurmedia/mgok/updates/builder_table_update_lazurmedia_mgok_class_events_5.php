<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokClassEvents5 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->time('time_from')->nullable()->default('00:00');
            $table->time('time_to')->default('00:00');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->dropColumn('time_from');
            $table->dropColumn('time_to');
        });
    }
}
