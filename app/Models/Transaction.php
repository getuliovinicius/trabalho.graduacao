<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['date', 'description', 'value', 'source_account_id', 'destination_account_id'];

    /**
     * Get the accounts that owns the transaction.
     */
    public function accountSource()
    {
        return $this->belongsTo(Account::class, 'source_account_id');
    }

    public function accountDestination()
    {
        return $this->belongsTo(Account::class, 'destination_account_id');
    }
}
