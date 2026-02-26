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
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('store_id')->constrained('stores');
            $table->foreignId('brand_id')->constrained('brands');

            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();

            $table->string('name');
            $table->string('slug')->unique();

            $table->enum('type', ['physical', 'digital'])->default('physical');

            $table->string('image')->nullable();
            $table->json('gallery_images')->nullable();

            $table->string('sku')->nullable()->unique();
            $table->unsignedInteger('quantity')->default(0);

            $table->decimal('price', 12, 2);
            $table->decimal('discount_price', 12, 2)->nullable();

            $table->enum('discount_type', ['fixed', 'percentage'])->nullable();
            $table->decimal('discount_value', 12, 2)->nullable();
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();

            $table->longText('description');
            $table->text('short_description');

            $table->json('tags')->nullable();

            $table->enum('manage_stock', ['yes', 'no'])->default('no');

            $table->integer('view_count')->nullable()->default(0);
            $table->boolean('is_feature')->default(false);
            $table->boolean('is_hot')->default(false);
            $table->boolean('is_new')->default(false);

            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
