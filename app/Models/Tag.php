<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quote;

class Tag extends Model
{
    use HasFactory;

    /**
     * Remove timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    public function quotes() {
        return $this->belongsToMany(Quote::class);
    }
}
