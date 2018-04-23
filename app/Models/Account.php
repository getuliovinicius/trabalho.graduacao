<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name', 'type', 'balance', 'user_id', 'category_id'];

    /**
     * Get the transactions for the accounts.
     */
    public function trasactions()
    {
        return $this->hasMany(Transactions::class);
    }
}
