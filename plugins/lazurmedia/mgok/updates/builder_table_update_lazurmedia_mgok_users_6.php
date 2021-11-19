<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokUsers6 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->increments('id')->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->integer('id')->change();
        });
    }
}
