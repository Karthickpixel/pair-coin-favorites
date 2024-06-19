<?php

namespace UserToAdmin\Favorites\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use UserToAdmin\Favorites\Models\Favorites;

class Tradepair extends Model
{
    use HasFactory;
    protected $table      = 'trade_pairs';
    protected $primaryKey = 'id';
}
