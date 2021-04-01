<?php namespace Waka\Crm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateUniqueAggTable extends Migration
{
    public function up()
    {
        Schema::create('wcli_wconfig_unique_aggs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('uniqueable_id')->unsigned();
            $table->string('uniqueable_type');
            $table->index(['uniqueable_id', 'uniqueable_type'], 'uniqueable');
            //
            $table->double('s_y')->default(0);
            $table->double('s_y_1')->default(0);
            $table->double('c_y')->default(0);
            $table->double('c_y_1')->default(0);
            $table->double('s_q')->default(0);
            $table->double('s_q_1')->default(0);
            $table->double('s_q_n_1')->default(0);
            $table->double('s_q_1_n_1')->default(0);
            $table->double('s_m')->default(0);
            $table->double('s_m_1')->default(0);
            $table->double('s_m_n_1')->default(0);
            $table->double('s_m_1_n_1')->default(0);
            $table->double('s_w_1')->default(0);
            $table->double('s_w_2')->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('wcli_wconfig_unique_aggs');
    }
}
