<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 255);
            $table->tinyInteger('rating')->default(0);
            $table->string('preview_path', 255);
            $table->date('release_at');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE films ADD FULLTEXT search(title)');

        Schema::create('dictionary_genres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 255);
            $table->timestamps();
        });

        Schema::create('films_genres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('film_id')->index();
            $table->uuid('genre_id')->index();
            $table->boolean('is_main');
            $table->timestamps();
        });

        Schema::create('films_photos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('film_id');
            $table->boolean('photo_path');
            $table->boolean('title');
            $table->boolean('description');
            $table->timestamps();
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('source_id');
            $table->string('source_type', 20);
            $table->uuid('user_id');
            $table->timestamps();
        });

        Schema::create('actors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('film_id');
            $table->string('full_name', 20);
            $table->timestamps();
        });

        Schema::create('directors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('film_id');
            $table->string('full_name', 20);
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('film_id');
            $table->text('body');
            $table->uuid('user_id');
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
        Schema::dropIfExists('films');
        Schema::dropIfExists('actors');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('directors');
        Schema::dropIfExists('films_genres');
        Schema::dropIfExists('films_photos');
        Schema::dropIfExists('dictionary_genres');
    }
}
