<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokAddictionalLessons4 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->integer('uniq_id')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->dropColumn('uniq_id');
        });
    }
}
