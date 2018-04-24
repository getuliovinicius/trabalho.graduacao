<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'user_id'];

    /**
     * Get the transactions for the account source.
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
