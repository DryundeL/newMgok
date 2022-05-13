<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLazurmediaMgokJournal9 extends Migration
{
    public function up()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->string('subject', 100)->change();
        });
    }
    
    public function down()
    {
        Schema::table('lazurmedia_mgok_journal', function($table)
        {
            $table->string('subject', 50)->change();
        });
    }
}
