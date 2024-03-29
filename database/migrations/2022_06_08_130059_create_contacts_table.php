<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config("bkb-offices.table_prefix") . 'contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("office_id");
            /**
             * Type of Wovosoft\BkbOffices\Enums\Types
             */
            $table->string("type")->nullable();
            $table->string("content");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config("bkb-offices.table_prefix") . 'contacts');
    }
};
