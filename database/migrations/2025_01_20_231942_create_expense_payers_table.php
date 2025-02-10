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
        Schema::create('expense_payers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
        });

        Schema::table('expense_payers', function (Blueprint $table) {
            $table->foreign('expense_id')->references('id')->on('expenses')
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
        Schema::table('expense_payers', function (Blueprint $table) {
            $table->dropForeign(['expense_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('expense_payers');
    }
};
