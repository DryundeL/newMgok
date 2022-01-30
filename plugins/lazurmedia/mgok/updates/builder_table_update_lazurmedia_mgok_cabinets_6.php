<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokCabinets6 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_cabinets', function($table)
        {
            $table->string('cabinet_number', 15)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_cabinets', function($table)
        {
            $table->integer('cabinet_number')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
