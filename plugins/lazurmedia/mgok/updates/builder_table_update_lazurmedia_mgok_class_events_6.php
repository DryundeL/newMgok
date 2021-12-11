<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokClassEvents6 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->time('time_from')->default(null)->change();
            $table->time('time_to')->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->time('time_from')->default('00:00:00')->change();
            $table->time('time_to')->default('00:00:00')->change();
        });
    }
}
