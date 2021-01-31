<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_number');
            $table->string('picturePass');
            $table->string('intro');
            $table->boolean('firstLogin')->default(false);
            $table->integer('school_id');
            $table->integer('language_id');
            $table->integer('one_pass');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('student_number');
            $table->dropColumn('picturePass');
            $table->dropColumn('intro');
            $table->dropColumn('firstLogin')->default(false);
            $table->dropColumn('shool_id');
            $table->dropColumn('language_id');
            $table->dropColumn('one_pass');
        });
    }
}
