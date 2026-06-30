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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');       // admin yang membuat
            $table->foreignId('category_id')->constrained()->onDelete('restrict');  // kategori wisata
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');                    // isi artikel (rich text / HTML)
            $table->string('thumbnail')->nullable();        // gambar utama artikel
            $table->json('image_gallery')->nullable();      // galeri foto tambahan (array URL)
            $table->string('location_name')->nullable();    // nama lokasi (misal: Makassar, Bali)
            $table->string('map_embed')->nullable();        // embed Google Maps URL/iframe
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('ticket_price_info')->nullable(); // info harga tiket
            $table->string('operating_hours')->nullable();   // jam operasional
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedBigInteger('views')->default(0); // jumlah views untuk artikel terpopuler
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
