<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;

    // Add 'request_type' to the fillable array
    protected $fillable = ['client_id', 'status', 'request', 'response', 'request_type'];

    // Relier ApiLog à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
