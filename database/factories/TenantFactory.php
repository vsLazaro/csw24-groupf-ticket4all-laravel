<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenants';

    protected $fillable = [
        'Nome',
        'InformaçõesDeContato',
        'ConfiguraçõesEspecíficas',
    ];

    // Relacionamento Um-para-Muitos com Usuário
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'TenantID');
    }

    // Relacionamento Um-para-Muitos com Evento
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'TenantID');
    }

    // Relacionamento Um-para-Muitos com Transação
    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'TenantID');
    }

    // Relacionamento Um-para-Muitos com Ticket
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'TenantID');
    }
}
