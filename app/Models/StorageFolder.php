<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageFolder extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    protected $with = ['files', 'conversion'];

    public function files()
    {
       return $this->hasMany(File::class);
    }

    public function conversion(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Conversion::class);
    }
}
