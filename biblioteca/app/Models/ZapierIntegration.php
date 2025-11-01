<?php

namespace App\Models;

use App\Http\Requests\ZapierIntegrationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\returnArgument;

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
        // public static function createFromRequest(ZapierIntegrationRequest $request)
        // {
        //     $e = new ZapierIntegration();
        //     $e->NomeIntegracao = 'ZapierGoogleDriveAPI';
        //     $e->Evento = $request->input('event', 'unknown');
        //     $e->Payload = $request->__tostring();
        //     $e->Ativo = true;
        //     $e->DataRecebimento =$request->createdDate ?? now();

        //     return $e;
        // }
}
