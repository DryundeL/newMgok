<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokJournal extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->string('student', 100);
            $table->integer('mark')->unsigned();
            $table->dropColumn('table');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->dropColumn('student');
            $table->dropColumn('mark');
            $table->text('table');
        });
    }
}
