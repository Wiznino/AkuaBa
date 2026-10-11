<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentSponsorship extends Model
{
    public const EQUIPMENT_OPTIONS = [
        'Projector and screen',
        '3.0 kW inverter generator',
        'Rechargeable PA system',
        'Cables, safety, and transport accessories',
        'Banners, facilitator T-shirts, wristbands, and STEM prizes',
    ];

    protected $fillable = [
        'contact_name',
        'email',
        'phone',
        'equipment',
        'message',
        'consented_at',
    ];
}
