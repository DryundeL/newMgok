<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokJournal2 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->date('date');
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->dropColumn('date');
        });
    }
}
