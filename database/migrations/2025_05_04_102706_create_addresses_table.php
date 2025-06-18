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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('primary_landmark');
            $table->string('secondary_landmark')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('pincode',6);
            $table->string('address')->nullable();
            $table->string('remark')->nullable();
            $table->boolean('is_default')->default(1)->comment('1:default, 0:optional');
             $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
