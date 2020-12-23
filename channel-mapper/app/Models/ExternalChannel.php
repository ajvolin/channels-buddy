<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExternalChannel
 * @package App\Models
 *
 */

class ExternalChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'channel_id',
        'channel_number',
        'channel_enabled'
    ];
}
