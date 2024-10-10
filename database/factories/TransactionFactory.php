<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacao extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'TenantID',
        'IDDoComprador',
        'IDDoTicket',
        'PreçoDeVenda',
        'DataDaTransação',
        'StatusDaTransação',
    ];

    // Relacionamento Muitos-para-Um com Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'TenantID');
    }

    // Relacionamento Muitos-para-Um com Usuario (como comprador)
    public function comprador()
    {
        return $this->belongsTo(Usuario::class, 'IDDoComprador');
    }

    // Relacionamento Um-para-Um com Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'IDDoTicket');
    }
}
