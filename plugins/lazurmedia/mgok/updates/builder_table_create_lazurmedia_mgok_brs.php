<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokBrs extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_brs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('module', 30)->nullable();
            $table->text('table')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_brs');
    }
}
