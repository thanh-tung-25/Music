<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('playlist_song', function (Blueprint $table) {
            //$table->integer('order')->nullable();
            //$table->timestamps();
            //$table->unique(['playlist_id', 'song_id']);
        });
    }
    
    public function down()
    {
        Schema::table('playlist_song', function (Blueprint $table) {
            $table->dropUnique(['playlist_id', 'song_id']);
            $table->dropColumn(['order']);
            $table->dropTimestamps();
        });
    }
    
};
