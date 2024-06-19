<?php

namespace UserToAdmin\Favorites\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use UserToAdmin\Favorites\Models\Tradepair;
use UserToAdmin\Favorites\Models\User;


class Favorites extends Model
{
    use HasFactory;
    protected $table       = 'favorites';
    protected $primaryKey  = 'id';
    protected $fillable    = ['user_id', 'coin_id', 'status'];

    ## Add or toggle favorite for a user.
    public function toggleFavorite($userId, $pairId)
    {
        $user = User::find($userId);
        if (!$user) {
            return 'User not found.';
        }

        $coin = Tradepair::find($pairId);
        if (!$coin) {
            return 'Tradepair coin not found.';
        }

        $favorite = $this->where('coin_id', $pairId)
                         ->where('user_id', $userId)
                         ->first();

        if ($favorite) {
            $favorite->status = $favorite->status === 0 ? 1 : 0;
            $favorite->save();
            $status = $favorite->status === 0 ? 'removed from favorites' : 'added to favorites';
        } else {
            $this->user_id = $userId;
            $this->coin_id = $pairId;
            $this->status  = 1;
            $this->save();
            $status = 'added to favorites';
        }

        return $status;
    }

    ## Get favorites pair data for a user.
    public function getFavoritesPairData($userId)
    {
        return DB::table('trade_pairs')
                    ->leftJoin('favorites', function ($join) use ($userId) {
                        $join->on('trade_pairs.id', '=', 'favorites.coin_id')
                            ->where('favorites.user_id', '=', $userId);
                    })
                    ->select('trade_pairs.*')
                    ->orderByRaw('IFNULL(favorites.status, 0) DESC')
                    ->orderByRaw('IFNULL(favorites.updated_at, trade_pairs.created_at) DESC')
                    ->orderBy('trade_pairs.id', 'ASC')
                    ->get();
    }
   
}
