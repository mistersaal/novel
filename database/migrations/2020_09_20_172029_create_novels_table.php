<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNovelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novels', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'author_id')->constrained('users');
            $table->string('name');
            $table->string('cover')->nullable();
            $table->text('description')->nullable();
            $table->foreignIdFor(\App\Models\Scene::class, 'first_scene_id')->nullable()->constrained('scenes');
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
        Schema::dropIfExists('novels');
    }
}
