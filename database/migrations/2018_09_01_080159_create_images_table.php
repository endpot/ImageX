<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 16)->unique()->comment('Image Unique Code');
            $table->string('delete_code', 16)->unique()->comment('Image Delete Code');
            $table->string('name', 255)->comment('Image File Name');
            $table->string('ext', 8)->comment('Image Extension');
            $table->integer('width')->comment('Image Width in Pixels');
            $table->integer('height')->comment('Image Height in Pixels');
            $table->boolean('nsfw')->default(false)->comment('Normal or NSFW');
            $table->string('uploader_ip', 64)->comment('Image Uploader IP');
            $table->string('fingerprint', 32)->comment('Image Fingerprint');
            $table->string('save_name', 32)->comment('Image Save Name');
            $table->unsignedBigInteger('size')->comment('Image Size in Bits');
            $table->unsignedBigInteger('views')->comment('Image View Counts');

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
        Schema::dropIfExists('images');
    }
}
