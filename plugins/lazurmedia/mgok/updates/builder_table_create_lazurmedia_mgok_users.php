<?php namespace Lazurmedia\Mgok\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLazurmediaMgokUsers extends Migration
{
    public function up()
    {
        Schema::create('lazurmedia_mgok_users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('login', 30);
            $table->string('password', 30);
            $table->string('role', 30);
            $table->string('full_name', 100);
            $table->string('class', 10);
            $table->date('date_of_birth');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('lazurmedia_mgok_users');
    }
}
