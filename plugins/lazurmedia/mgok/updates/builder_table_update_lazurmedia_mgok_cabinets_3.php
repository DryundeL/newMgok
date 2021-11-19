<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokCabinets3 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_cabinets', function($table)
        {
            $table->increments('id');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_cabinets', function($table)
        {
            $table->dropColumn('id');
        });
    }
}
