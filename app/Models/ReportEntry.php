<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportEntry extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
