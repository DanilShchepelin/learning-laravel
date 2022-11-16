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
        Schema::table('users', function (Blueprint $table) {
            $table->text('biography')
                ->after('remember_token')
                ->nullable(false);

            $table->date('year_of_birth')
                ->after('biography')
                ->nullable(false);

            $table->string('slug')
                ->after('year_of_birth')
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'biography',
                'year_of_birth',
                'slug'
            ]));
        });
    }
};
