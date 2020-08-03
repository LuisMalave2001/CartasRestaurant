<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class SetUserSessionVariables
{
    /**
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {

        $user = $event->user;

        $default_establishments = $user->establishments->first();

        session(
            [
                'user_current_establishment' => $default_establishments
            ]
        );
    }
}
?>
