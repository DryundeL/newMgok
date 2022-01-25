<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokJournal extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_journal', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('class', 10);
            $table->string('subject', 50);
            $table->text('table');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_journal');
    }
}
