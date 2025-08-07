<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundraisingWithdrawal extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['fundraising_id', 'fundraiser_id', 'has_received', 'has_set', 'amount_requested', 'amount_received', 'bank_name', 'bank_account_name', 'bank_account_number', 'proof'];

    public function fundraising()
    {
        return $this->belongsTo(Fundraising::class);
    }

    public function fundraiser()
    {
        return $this->belongsTo(Fundraiser::class);
    }
}
