<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public const TYPE = [
        'rent' => 'Rent',
        'sale' => 'Sale',
    ];

    public const STATUS = [
        'available' => 'Available',
        'pending' => 'Pending',
        'sold' => 'Sold',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
