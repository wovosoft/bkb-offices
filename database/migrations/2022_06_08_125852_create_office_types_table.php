<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Wovosoft\BkbOffices\Enums\OfficeTypes;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config("bkb-offices.table_prefix") . 'office_types', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("bn_name")->nullable();
            $table->string("description")->nullable();
            $table->enum(
                "type",
                array_map(fn($item) => $item->value, OfficeTypes::cases())
            )->unique();
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
        Schema::dropIfExists(config("bkb-offices.table_prefix") . 'office_types');
    }
};
