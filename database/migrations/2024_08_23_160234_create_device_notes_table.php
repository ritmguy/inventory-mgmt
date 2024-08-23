<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceNotesTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_notes', function (Blueprint $table) {
            $table->id();
            $table->string('device_uuid', 38)->index();
            $table->json('notes');
            $table->integer('user_id')->index();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_notes');
    }
}
