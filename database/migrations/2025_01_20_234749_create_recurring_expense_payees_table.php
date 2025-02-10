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
        Schema::create('recurring_expense_payees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recurring_expense_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });

        Schema::table('recurring_expense_payees', function (Blueprint $table) {
            $table->foreign('recurring_expense_id')->references('id')->on('recurring_expenses')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recurring_expense_payees', function (Blueprint $table) {
            $table->dropForeign(['recurring_expense_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('recurring_expense_payees');
    }
};
