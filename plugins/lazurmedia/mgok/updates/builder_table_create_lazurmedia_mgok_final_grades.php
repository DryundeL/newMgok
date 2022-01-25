<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokFinalGrades extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_final_grades', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('class', 15);
            $table->string('month', 30);
            $table->string('student', 100);
            $table->string('mark', 5)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_final_grades');
    }
}
