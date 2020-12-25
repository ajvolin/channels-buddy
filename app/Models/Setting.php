<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * @package App\Models
 *
 */

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting',
        'value'
    ];

    protected $primaryKey = 'setting';
    public $timestamps = false;

    public static function getSetting($setting, $value = null): ?string
    {
        return self::find($setting)->value ?? $value;
    }

    public static function updateSetting($setting, $value = null): ?string
    {
        return self::updateOrCreate(
            ['setting' => $setting],
            ['value' => $value]
        )->value;
    }
}
