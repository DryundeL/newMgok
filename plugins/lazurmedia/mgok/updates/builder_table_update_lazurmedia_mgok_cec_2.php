<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokCec2 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_cec', function($table)
        {
            $table->decimal('criteria_weight', 10, 2)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_cec', function($table)
        {
            $table->integer('criteria_weight')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
