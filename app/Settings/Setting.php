<?php

namespace App\Settings;

use Jenssegers\Model\Model;
use App\Settings\NullSetting;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use App\Settings\Exceptions\InvalidTypeCast;
use App\Settings\Models\Setting as SettingRepository;

class Setting extends Model
{
    /**
     * Cached settings collection.
     *
     * @var Collection
     */
    protected $cache;

    /**
     * Makes the instance.
     *
     * @return any
     */
    public static function make(string $name = '', $default = '')
    {
        $object = new static;
        $object->cache = SettingRepository::serializeForCache();

        if ($name) {
            return $object->get($name, $default);
        } else {
            return $object;
        }
    }

    /**
     * Casts the given value to the given type.
     *
     * @return any
     */
    public function cast(string $type, $value)
    {
        if ($type == 'string') return (string)$value;
        if ($type == 'int' || $type == 'integer') return (int)$value;
        if ($type == 'float') return (float)$value;

        if (class_exists($type)) {
            $class = new $type;

            if ($class instanceof EloquentModel) {
                return $class->findOrFail((int)$value);
            } else {
                return new $type($value);
            }
        }

        throw new InvalidTypeCast('Cannot cast to type '.$type);
    }

    /**
     * Gets the given key value.
     *
     * @return any
     */
    public function get(string $name, $default = '')
    {
        $setting = $this->cache->where('name', $name)->first();
        if (!$setting) return $default;

        $value = $setting->values;

        if (!$value) {
            $value = $setting->value;
        } else {
            $value = $value->first()->value;
        }

        return $this->cast($setting->cast, $value);
    }

    /**
     * Sets the given key value pair.
     *
     * @return self
     */
    public function set(string $name, $value, $default = NullSetting::class)
    {
        $setting = $this->cache->where('name', $name)->first();

        if (!$setting) {
            SettingRepository::create([
                'name' => $name,
                'cast' => gettype($value),
                'value' => $value,
                'default' => $default == NullSetting::class ? $value : $default
            ]);

            $this->cache = SettingRepository::serializeForCache();

            return $this->set($name, $value);
        }

        $userSetting = $setting->values;

        if ($userSetting) {
            $userSetting->first()->value = $value;
            $userSetting->first()->save();
        } else {
            $setting->persist($value);
        }

        return $this;
    }

    /**
     * Forgets the given setting.
     *
     * @return self
     */
    public function forget($name = null)
    {
        if (! $name) {
            $this->cache->each(function($setting) {
                $setting->delete();
            });
        } else {
            $setting = $this->cache->where('name', $name)->first();

            if ($setting) {
                $setting->delete();
            }
        }

        return $this;
    }
}
