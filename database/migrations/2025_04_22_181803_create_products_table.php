<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('seller_id');
            // Assuming 'users' table exists and has a primary key of 'id'
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->binary('image')->nullable(); // Tumetumia longBlob kwa picha kubwa
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->timestamps();
        });
          // Sasa tunabadilisha 'image' kuwa MEDIUMBLOB
          DB::statement('ALTER TABLE products MODIFY image MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
