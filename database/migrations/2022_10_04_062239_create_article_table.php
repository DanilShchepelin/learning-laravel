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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->text('title');

            $table->text('article_photo_path')
                ->nullable();

            $table->dateTime('announcement')
                ->nullable();

            $table->text('text');

            $table->foreignId('author_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('slug')
                ->index();
        });

        Schema::create('articles_categories', function (Blueprint $table) {
            $table->foreignId('article_id')
                ->constrained('articles');

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
        Schema::dropIfExists('articles_categories');
        Schema::dropIfExists('articles');
    }
};
