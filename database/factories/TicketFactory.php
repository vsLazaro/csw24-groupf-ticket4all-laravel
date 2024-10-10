<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'EventoID',
        'TenantID',
        'PreçoOriginal',
        'IDDoVendedor',
        'CódigoÚnicoDeVerificação',
        'Status',
    ];

    // Relacionamento Muitos-para-Um com Evento
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'EventoID');
    }

    // Relacionamento Muitos-para-Um com Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'TenantID');
    }

    // Relacionamento Muitos-para-Um com Usuario (como vendedor)
    public function vendedor()
    {
        return $this->belongsTo(Usuario::class, 'IDDoVendedor');
    }

    // Relacionamento Um-para-Um com Transação
    public function transacao()
    {
        return $this->hasOne(Transacao::class, 'IDDoTicket');
    }
}
