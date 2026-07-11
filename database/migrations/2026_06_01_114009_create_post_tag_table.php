<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_tag', static function (Blueprint $table) {
            $table->foreignUlid('post_ulid')
                ->constrained('posts', 'ulid')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignUlid('tag_ulid')
                ->constrained('tags', 'ulid')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
