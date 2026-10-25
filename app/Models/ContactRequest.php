<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'message_body',
        'service_type',
        'status',
    ];

    public const STATUSES = [
        'pending' => 'قيد الانتظار',
        'processed' => 'تمت المعالجة',
    ];
}