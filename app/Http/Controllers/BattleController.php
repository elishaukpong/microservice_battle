<?php

namespace App\Http\Controllers;

use App\Algorithm\Dice;
use Illuminate\Http\Request;

class BattleController extends Controller
{
    protected $battleAlgorithm = null;

    const USER_ENDPOINT = 'http://microservice_user_nginx/api/v1/user/';

    protected function setBattleAlgorithm()
    {
        $this->battleAlgorithm = new Dice();
    }

    public function duel(Request $request)
    {
        $this->setBattleAlgorithm();

        $duelResult = $this->battleAlgorithm->fight();

        $client = new Client(['verify' => false]);
        $player1Data = $client->get( self::USER_ENDPOINT . $request->input('userA'));
        $player2Data = $client->get( self::USER_ENDPOINT . $request->input('userB'));
        return response()->json( [
            'player1' => json_decode($player1Data->getBody()),
            'player2' => json_decode($player2Data->getBody()),
            'duelResults' => $duelResult
        ] );
    }
}
