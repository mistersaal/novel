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
            $table->foreignIdFor(\App\Models\Image::class)->nullable()->constrained()->onDelete('set null');
            $table->text('text')->nullable();
            $table->foreignIdFor(\App\Models\Music::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(\App\Models\Scene::class, 'next_scene_id')->nullable()->constrained('scenes')->onDelete('set null');
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
