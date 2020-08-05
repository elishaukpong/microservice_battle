<?php

namespace App\Http\Controllers;

use App\Algorithm\Dice;
use Illuminate\Http\Request;

class BattleController extends Controller
{
    protected $battleAlgorithm = null;

    protected function setBattleAlgorithm()
    {
        $this->battleAlgorithm = new Dice();
    }

    public function duel(Request $request)
    {
        $this->setBattleAlgorithm();

        $duelResult = $this->battleAlgorithm->fight();
        return response()->json( [
            'player1' => $request->input('userA'),
            'player2' => $request->input('userB'),
            'duelResults' => $duelResult
        ] );
    }
}
