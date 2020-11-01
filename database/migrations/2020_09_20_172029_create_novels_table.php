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
            $table->foreignIdFor(\App\Models\User::class, 'author_id')->constrained('users')->onDelete('cascade');
            $table->string('name')->unique();
            $table->foreignIdFor(\App\Models\Image::class)->nullable()->constrained('images')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->foreignIdFor(\App\Models\Scene::class, 'first_scene_id')->nullable()->constrained('scenes')->onDelete('cascade');
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
