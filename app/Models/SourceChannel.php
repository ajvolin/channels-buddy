<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SourceChannel
 * @package App\Models
 *
 */

class SourceChannel extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $primaryKey = 'channel_id';

    protected $fillable = [
        'source',
        'channel_id',
        'channel_number',
        'channel_enabled',
        'customizations'
    ];

    protected $casts = [
        'customizations' => 'array',
    ];
}
