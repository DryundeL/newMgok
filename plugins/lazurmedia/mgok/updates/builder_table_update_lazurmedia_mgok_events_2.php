<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokEvents2 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_events', function($table)
        {
            $table->renameColumn('creator', 'creater');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_events', function($table)
        {
            $table->renameColumn('creater', 'creator');
        });
    }
}
