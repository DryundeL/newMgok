<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokAddictionalLessons6 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->string('unique_id', 20)->nullable()->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->integer('unique_id')->nullable()->unsigned()->default(null)->change();
        });
    }
}
