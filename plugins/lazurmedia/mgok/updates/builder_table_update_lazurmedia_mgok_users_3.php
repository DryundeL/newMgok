<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokUsers3 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->string('class', 10)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->string('class', 10)->nullable(false)->change();
        });
    }
}
