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
       Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('colocation_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('payer_id')
                ->constrained('users');

            $table->string('category_name');

            $table->decimal('amount', 10, 2);

            $table->date('date');

            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};


