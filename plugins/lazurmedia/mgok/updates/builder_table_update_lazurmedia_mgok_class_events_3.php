<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokClassEvents3 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->dropColumn('day_of_week');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_class_events', function($table)
        {
            $table->string('day_of_week', 20);
        });
    }
}
