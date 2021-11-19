<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokUsers extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->dropColumn('id');
            $table->primary(['login']);
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->dropPrimary(['login']);
            $table->increments('id')->unsigned();
        });
    }
}
