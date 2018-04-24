<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name', 'type', 'balance', 'user_id', 'category_id'];

    /**
     * Get the transactions for the account source.
     */
    public function trasactionAccountSource()
    {
        return $this->hasMany(Transaction::class, 'source_account_id');
    }

    /**
     * Get the transactions for the account source.
     */
    public function trasactionAccountDestination()
    {
        return $this->hasMany(Transaction::class, 'destination_account_id');
    }
}
