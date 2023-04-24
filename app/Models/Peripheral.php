<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Peripheral extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    public function brand() { return $this->belongsTo(Brand::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function specifications() { return $this->belongsToMany(Specification::class); }
}
