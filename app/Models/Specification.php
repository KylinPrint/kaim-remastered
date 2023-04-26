<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
	use HasDateTimeFormatter;
    use HasFactory;
    use SoftDeletes;

    public function category() { return $this->belongsTo(Category::class); }
    public function peripherals() { return $this->belongsToMany(Peripheral::class); }
}
