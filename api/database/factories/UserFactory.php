<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'TenantID',
        'Nome',
        'Email',
    ];

    // Relacionamento Muitos-para-Um com Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'TenantID');
    }

    // Relacionamento Um-para-Muitos com Ticket (como vendedor)
    public function ticketsVendidos()
    {
        return $this->hasMany(Ticket::class, 'IDDoVendedor');
    }

    // Relacionamento Um-para-Muitos com Transação (como comprador)
    public function transacoesCompradas()
    {
        return $this->hasMany(Transacao::class, 'IDDoComprador');
    }

    // Relacionamento Um-para-Um com PreferênciasDeNotificação
    public function preferenciasNotificacao()
    {
        return $this->hasOne(PreferenciasDeNotificacao::class, 'UserID');
    }
}
