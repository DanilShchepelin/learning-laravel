<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article', function (Blueprint $table) {
            $table->id();

            $table->text('title');

            $table->text('article_photo_path')
                ->nullable();

            $table->dateTime('announcement')
                ->nullable();

            $table->text('text');

            $table->foreignId('author_id')->constrained('users');

            $table->string('slug')
                ->index();
        });

        Schema::create('article_category', function (Blueprint $table) {
            $table->foreignId('article_id')
                ->constrained('article');

            $table->foreignId('category_id')
                ->constrained('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('article');
    }
};
