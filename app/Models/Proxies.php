<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxies extends Model
{
    use HasFactory;

    protected $fillable = ['ip', 'port', 'type', 'country', 'city', 'status', 'speed', 'external_ip', 'check_id'];
}
