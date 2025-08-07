<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fundraiser extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['user_id', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fundraisings()
    {
        return $this->hasMany(Fundraising::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(FundraisingWithdrawal::class);
    }
}

