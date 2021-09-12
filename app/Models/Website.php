<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }

    public function latestSnapshot()
    {
        return $this->hasOne(Snapshot::class)->latestOfMany();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBaseUrlAttribute()
    {
        $url = parse_url($this->url);

        return "{$url['scheme']}://{$url['host']}";
    }
}
