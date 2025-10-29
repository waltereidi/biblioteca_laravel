<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZapierIntegration extends Model
{
    use HasFactory;

        protected $table = 'ZapierIntegration';
        protected $primaryKey = 'SeqZapierIntegration';

        protected $fillable = [
            'NomeIntegracao',
            'Evento',
            'Payload',
            'Ativo',
            'DataRecebimento',
            'FileLocation',
            'Log'
        ];

        protected $casts = [
            'Payload' => 'array',
            'Ativo' => 'boolean',
            'DataRecebimento' => 'datetime',
        ];
        public function appendLog($message)
        {
            $this->Log .= ($this->Log ? ' | ' : '') . $message;
            $this->save();
        }
}
