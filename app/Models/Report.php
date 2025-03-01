<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function entries()
    {
        return $this->hasMany(ReportEntry::class);
    }
}
