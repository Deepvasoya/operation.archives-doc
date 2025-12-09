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
        Schema::table('operations', function (Blueprint $table) {
            $table->text('description')->nullable()->after('operation_type_id');
            $table->date('date')->nullable()->after('description');
            $table->string('numero_operation')->nullable()->after('date');
            $table->string('piece_jointe')->nullable()->after('numero_operation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operations', function (Blueprint $table) {
            $table->dropColumn(['description', 'date', 'numero_operation', 'piece_jointe']);
        });
    }
};
