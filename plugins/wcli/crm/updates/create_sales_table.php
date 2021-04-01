<?php namespace Wcli\Crm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('wcli_crm_sales', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->integer('client_id')->unsigned();
            $table->integer('gamme_id')->unsigned();
            $table->double('montant', 15, 2);
            $table->date('sale_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wcli_crm_sales');
    }
}