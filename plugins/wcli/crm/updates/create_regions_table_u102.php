<?php namespace Wcli\Crm\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateRegionsTableU102 extends Migration
{
    public function up()
    {
        Schema::table('wcli_crm_regions', function (Blueprint $table) {
            $table->string('email')->default("inc@inc.com");
        });
    }

    public function down()
    {
        Schema::table('wcli_crm_regions', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
}
