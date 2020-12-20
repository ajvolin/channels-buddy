<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DvrChannel
 * @package App\Models
 *
 */

class PlutoChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel_id',
        'channel_number',
        'channel_enabled'
    ];
}
