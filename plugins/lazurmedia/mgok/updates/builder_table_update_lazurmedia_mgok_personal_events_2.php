<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokPersonalEvents2 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_personal_events', function($table)
        {
            $table->integer('creater');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_personal_events', function($table)
        {
            $table->dropColumn('creater');
        });
    }
}
