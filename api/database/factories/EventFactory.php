<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'TenantID',
        'NomeDoEvento',
        'Tipo',
        'Localização',
        'DataEHora',
    ];

    // Relacionamento Muitos-para-Um com Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'TenantID');
    }

    // Relacionamento Um-para-Muitos com Ticket
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'EventoID');
    }
}
