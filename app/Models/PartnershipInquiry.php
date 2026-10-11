<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnershipInquiry extends Model
{
    protected $fillable = [
        'organization',
        'contact_name',
        'email',
        'phone',
        'proposal',
        'consented_at',
    ];
}
