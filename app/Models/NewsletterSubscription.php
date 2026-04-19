<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    protected $table = 'newsletter_subscriptions';

    protected $fillable = [
        'email',
        'status',
        'confirmed',
        'confirmation_token',
        'confirmed_at',
        'unsubscribed_at',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
        'confirmed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('confirmed', true);
    }

    public function scopeUnconfirmed($query)
    {
        return $query->where('confirmed', false);
    }
}
