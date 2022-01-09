<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokCec6 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_cec', function($table)
        {
            $table->decimal('mechanical_engineering_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('economy_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('pharmaceuticals_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('it_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('math_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('linguistics_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('earth_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('foreign_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('health_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('design_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
            $table->decimal('tutor_ball', 10, 1)->nullable(false)->unsigned(false)->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_cec', function($table)
        {
            $table->integer('mechanical_engineering_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('economy_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('pharmaceuticals_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('it_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('math_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('linguistics_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('earth_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('foreign_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('health_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('design_ball')->nullable(false)->unsigned(false)->default(0)->change();
            $table->integer('tutor_ball')->nullable(false)->unsigned(false)->default(0)->change();
        });
    }
}
