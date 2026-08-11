<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUAEventsTable extends Migration
{
    public function up()
    {
        Schema::create('ua_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->text('description');
            $table->dateTime('event_date');
            $table->time('start_time');
            $table->integer('duration');
            $table->string('venue');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ua_events');
    }
}
