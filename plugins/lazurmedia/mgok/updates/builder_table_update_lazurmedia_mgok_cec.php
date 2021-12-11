<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokCec extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_cec', function($table)
        {
            $table->string('criteria', 255)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_cec', function($table)
        {
            $table->string('criteria', 191)->change();
        });
    }
}
