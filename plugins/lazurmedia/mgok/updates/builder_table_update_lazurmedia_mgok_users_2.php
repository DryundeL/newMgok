<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokUsers2 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->date('date_of_birth')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_users', function($table)
        {
            $table->date('date_of_birth')->nullable(false)->change();
        });
    }
}
