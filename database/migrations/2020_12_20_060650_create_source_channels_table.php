<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourceChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('source_channels', function (Blueprint $table) {
            $table->string('source', 100);
            $table->string('channel_id', 100)->unique();
            $table->string('channel_number', 16)->nullable();
            $table->boolean('channel_enabled')->nullable()->default(true);
            $table->longText('custom_logo')->nullable();
            $table->longText('custom_channel_art')->nullable();
            $table->timestamps();
            $table->primary(['source', 'channel_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('source_channels');
    }
}
