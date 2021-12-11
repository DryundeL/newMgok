<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokCabinets5 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_cabinets', function($table)
        {
            $table->string('address', 100)->nullable(false)->default('null')->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_cabinets', function($table)
        {
            $table->string('address', 100)->nullable()->default(null)->change();
        });
    }
}
