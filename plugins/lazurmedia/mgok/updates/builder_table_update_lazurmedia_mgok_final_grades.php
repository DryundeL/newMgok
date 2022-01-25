<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokFinalGrades extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_final_grades', function($table)
        {
            $table->string('subject', 50);
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_final_grades', function($table)
        {
            $table->dropColumn('subject');
        });
    }
}
