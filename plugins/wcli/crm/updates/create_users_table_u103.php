<?php namespace Waka\Crpf\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateUsersTableU103 extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function ($table) {
            $table->integer('crm_region_id')->unsigned()->nullable();
        });
    }

    public function down()
    {
        if (Schema::hasColumn('backend_users', 'crm_region_id')) {
            Schema::table('backend_users', function ($table) {
                $table->dropColumn('crm_region_id');
            });

        }
    }
}
