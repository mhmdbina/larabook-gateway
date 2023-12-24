<?php

namespace Larabookir\Gateway\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GatewayConfig extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'key',
        'value',
        'user_id',
    ];

    protected $casts = [
        'value' => 'json',
    ];

    public static function getConfigs()
    {
        $configs = self::get()->toArray();

        $formattedConfigs = [];
        foreach ($configs as $config) $formattedConfigs[$config['user_id']][$config['key']] = $config['value'];

        return $formattedConfigs;
    }

    public static function getSpecifiedFieldUserConfigs(int $user_id, string $key, string $field)
    {
        $config = self::where([['key', $key], ['user_id', $user_id]])->first()->toArray();

        if (!$config) return null;

        return $config['value'][$field];
    }
}
