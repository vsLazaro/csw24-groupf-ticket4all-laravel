<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferenciasDeNotificacao extends Model
{
    use HasFactory;

    protected $table = 'preferencias_de_notificacao';

    protected $fillable = [
        'UserID',
        'ReceberEmails',
    ];

    // Relacionamento Um-para-Um com Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UserID');
    }
}
