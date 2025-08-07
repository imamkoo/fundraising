<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fundraising extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = ['fundraiser_id', 'category_id', 'is_active', 'has_finished', 'name', 'slug', 'thumbnail', 'about', 'target_amount'];

    public function fundraiser()
    {
        return $this->belongsTo(Fundraiser::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function phases()
    {
        return $this->hasMany(FundraisingPhase::class);
    }

    public function donaturs()
    {
        return $this->hasMany(Donatur::class)->where('is_paid', true);
    }

    public function totalReachedAmount()
    {
        return $this->donaturs()->sum('total_amount');
    }

    public function withdrawals()
    {
        return $this->hasMany(FundraisingWithdrawal::class);
    }
    
    public function fundraising_phases()
    {
        return $this->hasMany(FundraisingPhase::class);
    }

    public function getPercentageAttribute()
    {
        $totalDonations = $this->totalReachedAmount();
        if($this->target_amount > 0) {
            $percentage = ($totalDonations / $this->target_amount) * 100;
            return $percentage > 100 ? 100 : $percentage;
        }
        return 0;
    }
}
