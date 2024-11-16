<?php


namespace App\Events;

use App\Models\Interaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InteractionCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $interaction;

    public function __construct(Interaction $interaction)
    {
        $this->interaction = $interaction;
    }
}