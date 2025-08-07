<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundraisingPhase extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['fundraising_id', 'name', 'photo', 'notes'];

    public function fundraising()
    {
        return $this->belongsTo(Fundraising::class);
    }
}
