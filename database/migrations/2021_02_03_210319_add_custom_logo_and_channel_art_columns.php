<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomLogoAndChannelArtColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('source_channels', function (Blueprint $table) {
            if(!Schema::hasColumn('source_channels', 'custom_logo')) {
                $table->longText('custom_logo')->nullable();
                $table->longText('custom_channel_art')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
        Schema::table('source_channels', function (Blueprint $table) {
            if(Schema::hasColumn('source_channels', 'custom_logo')) {
                $table->dropColumn(['custom_logo', 'custom_channel_art']);
            }
        });
    }
}
