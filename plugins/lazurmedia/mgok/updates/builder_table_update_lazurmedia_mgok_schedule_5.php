<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokSchedule5 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_schedule', function($table)
        {
            $table->string('cabinet', 15)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_schedule', function($table)
        {
            $table->integer('cabinet')->nullable()->unsigned(false)->default(null)->change();
        });
    }
}
