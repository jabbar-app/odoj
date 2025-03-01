<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    // Mutator untuk mengonversi member ke JSON string saat disimpan
    public function setMemberAttribute($value)
    {
        $this->attributes['member'] = json_encode($value);
    }

    // Accessor untuk mengonversi member ke array saat diambil
    public function getMemberAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
