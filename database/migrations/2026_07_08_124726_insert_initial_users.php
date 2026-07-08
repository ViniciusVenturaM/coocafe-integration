<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'vinicius',
                'usuario' => 'vinicius.ventura',
                'email' => 'vinicius.ventura@cresol.com.br',
                'password' => '$2y$12$HhWBTgRy/5ojBQHB/8rate6V9Vb5CNPRM7D8Ur8rZaOKqX3EUMxHa', //senha para local: $2y$12$H2WosJiWSo3bbTTO6rCVb.AWWr9Sv005OBy.yw7FmsuwGCICGCr0q
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'matheus',
                'usuario' => 'matheus.pazelli',
                'email' => 'matheus.pazelli@cresol.com.br',
                'password' => '$2y$12$HhWBTgRy/5ojBQHB/8rate6V9Vb5CNPRM7D8Ur8rZaOKqX3EUMxHa',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'rangel',
                'usuario' => 'rangel.moura',
                'email' => 'rangel.moura@cresol.com.br',
                'password' => '$2y$12$HhWBTgRy/5ojBQHB/8rate6V9Vb5CNPRM7D8Ur8rZaOKqX3EUMxHa',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'joao',
                'usuario' => 'joao.camargos',
                'email' => 'joao.camargos@cresol.com.br',
                'password' => '$2y$12$HhWBTgRy/5ojBQHB/8rate6V9Vb5CNPRM7D8Ur8rZaOKqX3EUMxHa',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->whereIn('usuario', [
            'vinicius.ventura',
            'matheus.pazelli',
            'rangel.moura',
            'joao.camargos'
        ])->delete();
    }
};
