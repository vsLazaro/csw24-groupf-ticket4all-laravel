<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ticket_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'seller_id',
        'tenant_id',
        'original_price',
        'verification_code',
        'status',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function seller()
    {
        return $this->belongsTo(Client::class, 'seller_id', 'client_id');
    }
}
