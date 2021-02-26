<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $fillable = ['currency_from', 'currency_to', 'value', 'converted_value', 'rate'];

    public function getValueAttribute()
    {
        return $this->attributes['value'] / 100000000;
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = $value * 100000000;
    }

    public function getConvertedValueAttribute()
    {
        return $this->attributes['converted_value'] / 100000000;
    }

    public function setConvertedValueAttribute($value)
    {
        $this->attributes['converted_value'] = $value * 100000000;
    }
}
