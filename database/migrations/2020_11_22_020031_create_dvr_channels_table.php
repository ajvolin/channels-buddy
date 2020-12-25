<?php

use App\Models\DvrLineup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDvrChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvr_channels', function (Blueprint $table) {
            $table->id();
            $table->string('guide_number', 16)->unique();
            $table->string('mapped_channel_number', 16)->nullable();
            $table->boolean('channel_enabled')->nullable()->default(true);
            $table->timestamps();
        });

        DB::raw('
            CREATE TRIGGER trg_mapped_default
                AFTER INSERT ON dvr_channels
                FOR EACH ROW
                WHEN (NEW.mapped_channel_number IS NULL)
                BEGIN
                    UPDATE dvr_channels
                    SET mapped_channel_number = NEW.guide_number
                    WHERE id = NEW.id;
                END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::raw('DROP TRIGGER trg_mapped_default');

        Schema::dropIfExists('dvr_channels');
    }
}
