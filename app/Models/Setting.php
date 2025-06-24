<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * Get setting value with proper type casting
     */
    public function getTypedValueAttribute()
    {
        if ($this->value === null) {
            return null;
        }

        return match ($this->type) {
            'boolean' => (bool) $this->value,
            'integer' => (int) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    /**
     * Set setting value with proper type handling
     */
    public function setTypedValueAttribute($value)
    {
        if ($value === null) {
            $this->value = null;
            return;
        }

        $this->value = match ($this->type) {
            'boolean' => $value ? '1' : '0',
            'integer' => (string) $value,
            'json' => is_array($value) ? json_encode($value) : $value,
            default => (string) $value,
        };
    }

    /**
     * Get setting by key with caching
     */
    public static function getValue(string $key, $default = null)
    {
        $cacheKey = "setting.{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->typed_value : $default;
        });
    }

    /**
     * Set setting value
     */
    public static function setValue(string $key, $value): bool
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return false;
        }

        $setting->typed_value = $value;
        $setting->save();

        // Clear cache
        Cache::forget("setting.{$key}");

        return true;
    }

    /**
     * Get settings by group
     */
    public static function getByGroup(string $group)
    {
        return static::where('group', $group)->get();
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting.{$setting->key}");
        }
    }
} 