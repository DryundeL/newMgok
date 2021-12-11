<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokCec5 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_cec', function($table)
        {
            $table->integer('block');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_cec', function($table)
        {
            $table->dropColumn('block');
        });
    }
}
