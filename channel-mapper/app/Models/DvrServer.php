<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DvrServer
 * @package App\Models
 *
 */

class DvrServer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'server_host',
        'server_port',
        'playlist_host',
        'playlist_port',
        'auth_token'
    ];

    protected $primaryKey = 'name';
    public $timestamps = false;
}
