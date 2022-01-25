<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokAddictionalLessons3 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->string('subject', 30);
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->dropColumn('subject');
        });
    }
}
