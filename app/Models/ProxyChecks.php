<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProxyChecks extends Model
{
    use HasFactory;

    protected $fillable = ['started_at', 'finished_at', 'total_proxies', 'working_proxies'];
}
