<?php

use App\Models\StaticPage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Product\Models\Product;
use Modules\Wishlist\Models\Wishlist;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Wishlist::getDb(), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete('cascade')->cascadeOnUpdate();
            $table->foreign('product_id')->references('id')->on(Product::getDb())->cascadeOnDelete('cascade')->cascadeOnUpdate();
            Wishlist::timestampFields($table);
        });
        StaticPage::createSystemPage('Wishlist', 'wishlist');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Wishlist::getDb());
    }
};
