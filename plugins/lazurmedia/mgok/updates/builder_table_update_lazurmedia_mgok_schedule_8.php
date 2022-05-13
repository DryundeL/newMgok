<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokSchedule8 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_schedule', function($table)
        {
            $table->string('lesson_name', 150)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_schedule', function($table)
        {
            $table->string('lesson_name', 100)->change();
        });
    }
}
