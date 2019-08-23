<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameLevelAdminApprovalSysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_approval_sys', function (Blueprint $table) {
            $table->renameColumn('level','levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_approval_sys', function (Blueprint $table) {
            $table->renameColumn('levels','level');
        });
    }
}
