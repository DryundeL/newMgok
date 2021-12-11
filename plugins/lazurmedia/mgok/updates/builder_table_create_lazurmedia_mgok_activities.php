<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokActivities extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_activities', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('activity_name', 50);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_activities');
    }
}
