<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $prefix = 'X';
    public function up(): void
    {
        Schema::create('auditoriums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_seats')->default(40);
            $table->timestamps();
        });

        for($i = 1; $i <= 20; ++$i) {
            DB::table('auditoriums')->insert([
                'name' => $this->prefix . $i,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoriums');
    }
};
