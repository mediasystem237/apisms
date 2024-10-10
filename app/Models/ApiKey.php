<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'api_key'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}
