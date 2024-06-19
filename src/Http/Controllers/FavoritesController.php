<?php

namespace UserToAdmin\Favorites\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UserToAdmin\Favorites\Models\Favorites;
use UserToAdmin\Favorites\Models\Tradepair;
use UserToAdmin\Favorites\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{

    private $userId;

    public function __construct()
    {
        // $this->userId = Auth::id();
         $this->userId = Auth::id();
    }

    ## Toggle favorite pair for the authenticated user.
    public function toggleFavoritePair(Request $request, $pairId)
    {
        if (!$this->userId || !$pairId) {
            return response()->json(['status' => false, 'message' => 'Invalid user ID or pair ID.'], 400);
        }

        $favoritesModel = new Favorites();
        $status         = $favoritesModel->toggleFavorite($this->userId, $pairId);

        return response()->json(['status' => true, 'message' => $status]);
    }


    ## Get favorites pair data for the authenticated user.
    public function favoritesPairList()
    {
        $user = User::find($this->userId);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        $favoritesModel    = new Favorites();
        $favoritesPairData = $favoritesModel->getFavoritesPairData($this->userId);

        if ($favoritesPairData->isEmpty()) {
            return response()->json(['status' => true, 'data' => 'No Favorites Coin Data Available']);
        } else {
            return response()->json(['status' => true, 'data' => $favoritesPairData]);
        }
    }

   
}

