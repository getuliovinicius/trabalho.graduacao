<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['date', 'cofirmed', 'description', 'value', 'source_account_id', 'destination_account_id'];

    /**
     * Gets the transaction's source account.
     */
    public function accountSource()
    {
        return $this->belongsTo(Account::class, 'source_account_id');
    }

    /**
     * Gets the transaction target account.
     */
    public function accountDestination()
    {
        return $this->belongsTo(Account::class, 'destination_account_id');
    }
}
