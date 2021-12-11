<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokPersonalEvents3 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_personal_events', function($table)
        {
            $table->string('creater', 10)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_personal_events', function($table)
        {
            $table->integer('creater')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
