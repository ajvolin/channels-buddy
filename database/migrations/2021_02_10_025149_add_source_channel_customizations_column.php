<?php

use App\Models\SourceChannel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSourceChannelCustomizationsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('source_channels', function (Blueprint $table) {
            if(!Schema::hasColumn('source_channels', 'customizations')) {
                $table->longText('customizations')->nullable();
            }
        });

        if(Schema::hasColumn('source_channels', 'custom_logo')) {
            SourceChannel::whereNotNull('custom_logo')
                ->orWhereNotNull('custom_channel_art')
                ->get()
                ->each(function($channel) {
                    $customizations = [];
                    if(!is_null($channel->custom_logo)) {
                        $customizations['custom_logo'] =
                            $channel->custom_logo;
                    }
                    if(!is_null($channel->custom_channel_art)) {
                        $customizations['custom_channel_art'] =
                            $channel->custom_channel_art;
                    }
                    $channel->customizations = $customizations;
                    $channel->save();
                });

            Schema::table('source_channels', function (Blueprint $table) {
                $table->dropColumn(['custom_logo', 'custom_channel_art']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(!Schema::hasColumn('source_channels', 'custom_logo')) {
            Schema::table('source_channels', function (Blueprint $table) {
                $table->longText('custom_logo')->nullable();
                $table->longText('custom_channel_art')->nullable();
            });
        }

        if(Schema::hasColumn('source_channels', 'customizations')) {
            SourceChannel::whereNotNull('customizations')
                ->get()
                ->each(function($channel) {
                    $channel->custom_logo = 
                        $channel->customizations['custom_logo'] ?? null;
                    $channel->custom_channel_art = 
                        $channel->customizations['custom_channel_art'] ?? null;
                    $channel->save();
                });

            Schema::table('source_channels', function (Blueprint $table) {
                $table->dropColumn('customizations');
            });
        }
    }
}
