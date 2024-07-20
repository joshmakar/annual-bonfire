<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Ghost;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The First Born
        Ghost::create([
            'name' => 'The First Born',
            'card_front' => 'the-first-born-front.png',
            'card_back' => 'the-first-born-back.png',
        ]);

        // The Pilgrim
        Ghost::create([
            'name' => 'The Pilgrim',
            'card_front' => 'the-pilgrim-front.png',
            'card_back' => 'the-pilgrim-back.png',
        ]);

        // The Torso
        Ghost::create([
            'name' => 'The Torso',
            'card_front' => 'the-torso-front.png',
            'card_back' => 'the-torso-back.png',
        ]);

        // The Juggernaut
        Ghost::create([
            'name' => 'The Juggernaut',
            'card_front' => 'the-juggernaut-front.png',
            'card_back' => 'the-juggernaut-back.png',
        ]);

        // The Bound
        Ghost::create([
            'name' => 'The Bound',
            'card_front' => 'the-bound-front.png',
            'card_back' => 'the-bound-back.png',
        ]);

        // The Withered
        Ghost::create([
            'name' => 'The Withered',
            'card_front' => 'the-withered-front.png',
            'card_back' => 'the-withered-back.png',
        ]);

        // The Torn Princeps
        Ghost::create([
            'name' => 'The Torn Princeps',
            'card_front' => 'the-torn-princeps-front.png',
            'card_back' => 'the-torn-princeps-back.png',
        ]);

        // The Angry Royal
        Ghost::create([
            'name' => 'The Angry Royal',
            'card_front' => 'the-angry-royal-front.png',
            'card_back' => 'the-angry-royal-back.png',
        ]);

        // The Great Child
        Ghost::create([
            'name' => 'The Great Child',
            'card_front' => 'the-great-child-front.png',
            'card_back' => 'the-great-child-back.png',
        ]);

        // The Dire Parent
        Ghost::create([
            'name' => 'The Dire Parent',
            'card_front' => 'the-dire-parent-front.png',
            'card_back' => 'the-dire-parent-back.png',
        ]);

        // The Hammer
        Ghost::create([
            'name' => 'The Hammer',
            'card_front' => 'the-hammer-front.png',
            'card_back' => 'the-hammer-back.png',
        ]);

        // The Jackal
        Ghost::create([
            'name' => 'The Jackal',
            'card_front' => 'the-jackal-front.png',
            'card_back' => 'the-jackal-back.png',
        ]);

        // The Broken Heart
        Ghost::create([
            'name' => 'The Broken Heart',
            'card_front' => 'the-broken-heart-front.png',
            'card_back' => 'the-broken-heart-back.png',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ghosts', function (Blueprint $table) {
            //
        });
    }
};
