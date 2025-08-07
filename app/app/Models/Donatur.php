<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['fundraising_id', 'name', 'total_amount', 'notes', 'is_paid', 'proof', 'phone_number'];

    public function fundraising()
    {
        return $this->belongsTo(Fundraising::class);
    }

}
