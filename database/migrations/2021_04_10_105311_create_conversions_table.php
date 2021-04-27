<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('storage_folder_id');
            $table->string('from_type');
            $table->string('to_type');
            $table->string('status')->default('in_progress');
            $table->dateTime('converted_at')->nullable();
            $table->dateTime('zipped_at')->nullable();
            $table->dateTime('downloaded_at')->nullable();
            $table->timestamps();

            $table->foreign('storage_folder_id')
                ->references('id')
                ->on('storage_folders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversions');
    }
}
