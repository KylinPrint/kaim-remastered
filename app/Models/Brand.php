<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	use HasDateTimeFormatter;
    use HasFactory;
    use SoftDeletes;

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function () { if ($this->subname) { return $this->name . '(' . $this->subname . ')'; } else { return $this->name; } },
        );
    }

    protected $appends = ['full_name'];

    public function peripherals() { return $this->hasMany(Peripheral::class); }
}
