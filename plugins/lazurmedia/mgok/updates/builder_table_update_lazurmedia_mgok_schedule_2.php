<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokSchedule2 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_schedule', function($table)
        {
            $table->string('parity', 20)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_schedule', function($table)
        {
            $table->integer('parity')->nullable(false)->unsigned()->default(null)->change();
        });
    }
}
