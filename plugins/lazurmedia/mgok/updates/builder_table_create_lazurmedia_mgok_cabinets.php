<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokCabinets extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_cabinets', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('cabinet_number');
            $table->string('owner', 100)->nullable();
            $table->string('cabinet_name', 100);
            $table->primary(['cabinet_number']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_cabinets');
    }
}
