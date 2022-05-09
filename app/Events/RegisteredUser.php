<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegisteredUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(User|Authenticatable $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }
}
