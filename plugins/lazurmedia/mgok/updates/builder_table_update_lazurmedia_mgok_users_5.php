<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokUsers5 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->primary(['id']);
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->dropPrimary(['id']);
        });
    }
}
