<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';
    protected $fillable = [
        'title',
        'description',
        'color',
        'status'
    ];
    protected $appends = ['edit'];

    public function images()
    {
        return $this->hasMany(Image::class, 'note_id', 'id');
    }

    public function getEditAttribute()
    {
        return false;
    }
}
