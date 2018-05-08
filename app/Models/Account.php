<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name', 'type', 'balance', 'user_id', 'category_id'];

    /**
     * Gets account-related transactions. (account source)
     */
    public function trasactionAccountSource()
    {
        return $this->hasMany(Transaction::class, 'source_account_id');
    }

    /**
     * Gets account-related transactions. (destination source)
     */
    public function trasactionAccountDestination()
    {
        return $this->hasMany(Transaction::class, 'destination_account_id');
    }
}
