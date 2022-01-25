<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokJournal3 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->string('lesson_type', 50)->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->dropColumn('lesson_type');
        });
    }
}
