<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'user_id'];

    /**
     * Gets the category-related accounts.
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
