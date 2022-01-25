<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokAddictionalLessons extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_addictional_lessons', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name_lesson', 15);
            $table->date('date_lesson');
            $table->string('student', 100);
            $table->string('mark', 5);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_addictional_lessons');
    }
}
