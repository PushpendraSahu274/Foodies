<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_category_id')->constrained('meal_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('is_available')->default(1)->comment('1:available, 0:out_of_stocks');
            $table->decimal('mrp', 10, 2);
            $table->text('picture_path')->nullable();
            $table->integer('discount_percentage')->default(0)->comment('Discount percentage applied to the product');
            $table->boolean('best_seller')->default(1)->comment('1:best_seller, 0:not best_seller');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
