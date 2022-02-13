<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokAddictionalLessons5 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->renameColumn('uniq_id', 'unique_id');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->renameColumn('unique_id', 'uniq_id');
        });
    }
}
