<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('User', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('username', 50);
            $table->string('user_email', 50)->unique();
            $table->string('password_hash', 255);
            $table->enum('user_role', ['Admin', 'Client']);
            $table->string('status', 50);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        Schema::create('Customer', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->unsignedInteger('user_id');
            $table->string('full_name', 50);
            $table->string('email_customer', 50)->unique();
            $table->string('phone_customer', 20);
            $table->timestamp('created_at')->nullable();

            $table->foreign('user_id')->references('user_id')->on('User')->cascadeOnDelete();
        });

        Schema::create('CustomerAddress', function (Blueprint $table) {
            $table->increments('address_id');
            $table->unsignedInteger('customer_id');
            $table->string('street', 100);
            $table->string('city', 100);
            $table->string('zip', 20);
            $table->unsignedInteger('country_id');
            $table->string('country_name', 50);

            $table->foreign('customer_id')->references('customer_id')->on('Customer')->cascadeOnDelete();
        });

        Schema::create('Category', function (Blueprint $table) {
            $table->increments('category_id');
            $table->string('name', 50);
        });

        Schema::create('Product', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('name_product', 50);
            $table->decimal('price', 10, 2);
            $table->integer('stock_quantity');
            $table->unsignedInteger('category_id');
            $table->string('color', 50);
            $table->string('size', 50);
            $table->string('image_url', 255);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('category_id')->references('category_id')->on('Category');
        });

        Schema::create('ProductVariant', function (Blueprint $table) {
            $table->increments('variant_id');
            $table->unsignedInteger('product_id');
            $table->string('size', 50);
            $table->string('color', 50);
            $table->integer('stock');

            $table->foreign('product_id')->references('product_id')->on('Product')->cascadeOnDelete();
        });

        Schema::create('Wishlist', function (Blueprint $table) {
            $table->increments('wishlist_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('product_id');

            $table->foreign('customer_id')->references('customer_id')->on('Customer')->cascadeOnDelete();
            $table->foreign('product_id')->references('product_id')->on('Product')->cascadeOnDelete();
        });

        Schema::create('ProductReview', function (Blueprint $table) {
            $table->increments('review_id');
            $table->integer('rating');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('product_id');
            $table->text('comment');

            $table->foreign('customer_id')->references('customer_id')->on('Customer')->cascadeOnDelete();
            $table->foreign('product_id')->references('product_id')->on('Product')->cascadeOnDelete();
        });

        Schema::create('Cart', function (Blueprint $table) {
            $table->increments('cart_id');
            $table->integer('quantity');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('customer_id');

            $table->foreign('product_id')->references('product_id')->on('Product')->cascadeOnDelete();
            $table->foreign('customer_id')->references('customer_id')->on('Customer')->cascadeOnDelete();
        });

        Schema::create('Orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->unsignedInteger('customer_id');
            $table->decimal('total_amount', 10, 2);
            $table->string('status', 50);
            $table->string('shipping_address', 255);
            $table->string('payment_method', 50);
            $table->dateTime('order_date')->nullable();

            $table->foreign('customer_id')->references('customer_id')->on('Customer');
        });

        Schema::create('OrderLine', function (Blueprint $table) {
            $table->increments('orderline_id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);

            $table->foreign('order_id')->references('order_id')->on('Orders')->cascadeOnDelete();
            $table->foreign('product_id')->references('product_id')->on('Product');
        });

        Schema::create('ShippingMethod', function (Blueprint $table) {
            $table->increments('method_id');
            $table->string('method_name', 50);
            $table->decimal('cost', 10, 2);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ShippingMethod');
        Schema::dropIfExists('OrderLine');
        Schema::dropIfExists('Orders');
        Schema::dropIfExists('Cart');
        Schema::dropIfExists('ProductReview');
        Schema::dropIfExists('Wishlist');
        Schema::dropIfExists('ProductVariant');
        Schema::dropIfExists('Product');
        Schema::dropIfExists('Category');
        Schema::dropIfExists('CustomerAddress');
        Schema::dropIfExists('Customer');
        Schema::dropIfExists('User');
    }
};
