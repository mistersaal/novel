<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scenes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Image::class)->constrained()->onDelete('cascade');
            $table->text('text')->nullable();
            $table->foreignIdFor(\App\Models\Music::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Scene::class, 'next_scene_id')->nullable()->constrained('scenes')->onDelete('cascade');
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
        Schema::dropIfExists('scenes');
    }
}
