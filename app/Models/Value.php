<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $fillable = [
        'specification_id',
        'value',
    ];

    public function peripheral() { return $this->belongsTo(Peripheral::class); }
}
