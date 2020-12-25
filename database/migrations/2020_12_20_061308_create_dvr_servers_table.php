<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDvrServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvr_servers', function (Blueprint $table) {
            $table->string('name', 100)->unique();
            $table->string('display_name', 255);
            $table->string('server_host', 255);
            $table->string('server_port', 5)->default('8089');
            $table->string('playlist_host', 255)->nullable();
            $table->string('playlist_port', 5)->nullable();
            $table->string('auth_token', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dvr_servers');
    }
}
