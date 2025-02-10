<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->comment('https://www.iso.org/iso-4217-currency-codes.html
https://www.six-group.com/en/products-services/financial-information/data-standards.html

https://www.iban.com/currency-codes');
            $table->unsignedSmallInteger('id')->primary()->comment('Ref: https://www.iso.org/iso-4217-currency-codes.html');
            $table->string('currency_name', 100);
            $table->string('alphabetic_code', 4)->nullable()->unique('unq_currencies_alphabetic_code');
            $table->string('numeric_code', 4)->nullable()->unique('unq_currencies_numeric_code');
            $table->unsignedTinyInteger('minor_unit')->nullable();
            $table->unsignedTinyInteger('minor_unit_in_direct_quote')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
