<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    public function peripherals() { return $this->belongsToMany(Peripheral::class); }
}
