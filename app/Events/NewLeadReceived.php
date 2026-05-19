<?php

namespace App\Events;

use App\Models\Lead;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewLeadReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(
        public Lead $lead
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('leads.' . $this->lead->imovel->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->lead->id,
            'nome' => $this->lead->nome,
            'email' => $this->lead->email,
            'telefone' => $this->lead->telefone,
            'tipo_proposta' => $this->lead->tipo_proposta,
            'imovel_titulo' => $this->lead->imovel->titulo,
            'created_at' => $this->lead->created_at->diffForHumans(),
        ];
    }
}
