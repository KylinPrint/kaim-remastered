<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasDateTimeFormatter;
    use HasFactory;
    use ModelTree;
    use SoftDeletes;

    public function peripherals() { return $this->hasMany(Peripheral::class); }
    public function specifications() { return $this->hasMany(Specification::class); }
}
