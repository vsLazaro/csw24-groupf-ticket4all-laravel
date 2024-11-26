<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'tenant_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'contact_information',
        'specific_information',
    ];

    public function clients()
    {
        return $this->hasMany(Client::class, 'tenant_id', 'tenant_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'tenant_id', 'tenant_id');
    }
}
