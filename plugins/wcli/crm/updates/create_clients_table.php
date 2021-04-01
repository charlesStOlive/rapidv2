<?php namespace Wcli\Crm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('wcli_crm_clients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('siret')->nullable();
            $table->string('email')->nullable();
            $table->integer('region_id')->unsigned()->nullable();
            $table->text('address')->nullable();
            $table->string('cp')->nullable();
            $table->string('city')->nullable();
            $table->string('tel')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wcli_crm_clients');
    }
}