<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('url_shorteners', function (Blueprint $table) {
            $table->string('code')->nullable()->after('url_key');
            $table->text('description')->nullable()->after('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('url_shorteners', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('description');
        });
    }
}
