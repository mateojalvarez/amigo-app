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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 50)->unique()->index('balances_uuid_index');
            $table->unsignedBigInteger('from_user_id');
            $table->unsignedBigInteger('to_user_id');
            $table->decimal('amount', 10, 2);
            $table->unsignedSmallInteger('currency_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });

        Schema::table('balances', function (Blueprint $table) {
            $table->foreign('from_user_id', 'balances_from_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('to_user_id', 'balances_to_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('currency_id', 'balances_currency_id_foreign')
                ->references('id')
                ->on('currencies')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balances', function (Blueprint $table) {
            $table->dropForeign('balances_from_user_id_foreign');
            $table->dropForeign('balances_to_user_id_foreign');
            $table->dropForeign('balances_currency_id_foreign');
        });

        Schema::dropIfExists('balances');
    }
};
