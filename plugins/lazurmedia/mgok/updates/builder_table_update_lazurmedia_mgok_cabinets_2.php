<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokCabinets2 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_cabinets', function($table)
        {
            $table->dropPrimary(['cabinet_number']);
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_cabinets', function($table)
        {
            $table->primary(['cabinet_number']);
        });
    }
}
