<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokJournal9 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->integer('number_lesson')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->dropColumn('number_lesson');
        });
    }
}
