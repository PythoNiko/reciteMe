<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_data', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->string('guid');
            $table->text('description'); // unsure if there is a limit on this field so will use text for now...
            $table->dateTime('pub_date');
            $table->json('categories')->nullable(); // store as json for now, will revisit how to capture categories later...
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_data');
    }
}
