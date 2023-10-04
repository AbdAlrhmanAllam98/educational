<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class Model extends \Illuminate\Database\Eloquent\Model
{

    public function getCreatedAtAttribute($value): string
    {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(Config::get('app.timezone'))
            ->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value): string
    {
        return Carbon::createFromTimestamp(strtotime($value))
            ->timezone(Config::get('app.timezone'))
            ->toDateTimeString();
    }
}
