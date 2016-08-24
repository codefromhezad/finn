<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    
    public function budgetEntries() {
        return $this->hasMany('App\BudgetEntry');
    }



    public function visibleAccount() {
        return number_format(BudgetEntry::where('user_id', $this->id)
                        ->where('checked', 1)
                        ->sum('amount'), 2);
    }

    public function realAccount() {
        return number_format(BudgetEntry::where('user_id', $this->id)
                        ->sum('amount'), 2);
    }

    public function sumCardInPreviousPeriod($num_days) {
        $channel_id = \App\BudgetChannel::where('slug', 'carte-credit')->first()->id;

        return number_format(abs(BudgetEntry::where('user_id', $this->id)
                        ->where('date', '>=', Carbon::now()->subDays($num_days))
                        ->where('channel_id', $channel_id)
                        ->sum('amount')), 2);
    }

    public function sumWithdrawInPreviousPeriod($num_days) {
        $channel_id = \App\BudgetChannel::where('slug', 'retrait')->first()->id;

        return number_format(abs(BudgetEntry::where('user_id', $this->id)
                        ->where('date', '>=', Carbon::now()->subDays($num_days))
                        ->where('channel_id', $channel_id)
                        ->sum('amount')), 2);
    }
}
