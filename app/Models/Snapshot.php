<?php

namespace App\Models;

use App\Mail\WebsiteChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Snapshot extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'website_id'];

    protected static function booted()
    {
        static::created(function ($snapshot) {
            if ($snapshot->website->snapshots->count() <= 1) {
                return;
            }

            Mail::to($snapshot->website->user)
                ->queue(new WebsiteChanged($snapshot->website));
        });
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
