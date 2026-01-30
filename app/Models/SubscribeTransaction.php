<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribeTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'subscribe_transactions';

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'total_amount',
        'is_paid',
        'subscription_start_date',
        'proof',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'total_amount' => 'decimal:2',
        'subscription_start_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
