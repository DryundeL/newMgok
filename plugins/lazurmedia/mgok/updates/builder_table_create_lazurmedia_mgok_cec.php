<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokCec extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_cec', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('chapter', 30);
            $table->string('criteria');
            $table->integer('criteria_weight');
            $table->integer('mechanical_engineering_input')->nullable();
            $table->integer('mechanical_engineering_ball')->default(0);
            $table->integer('economy_input')->nullable();
            $table->integer('economy_ball')->default(0);
            $table->integer('pharmaceuticals_input')->nullable();
            $table->integer('pharmaceuticals_ball')->default(0);
            $table->integer('it_input')->nullable();
            $table->integer('it_ball')->default(0);
            $table->integer('math_input')->nullable();
            $table->integer('math_ball')->default(0);
            $table->integer('linguistics_input')->nullable();
            $table->integer('linguistics_ball')->default(0);
            $table->integer('earth_input')->nullable();
            $table->integer('earth_ball')->default(0);
            $table->integer('foreign_input')->nullable();
            $table->integer('foreign_ball')->default(0);
            $table->integer('health_input')->nullable();
            $table->integer('health_ball')->default(0);
            $table->integer('design_input')->nullable();
            $table->integer('design_ball')->default(0);
            $table->integer('tutor_input')->nullable();
            $table->integer('tutor_ball')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_cec');
    }
}
