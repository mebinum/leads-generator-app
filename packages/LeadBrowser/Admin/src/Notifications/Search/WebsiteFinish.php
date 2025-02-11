<?php

namespace LeadBrowser\Admin\Notifications\Search;

use LeadBrowser\Search\Models\SearchLocations;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;

class WebsiteFinish extends Mailable
{
    /**
     * @param  object  $user
     * @return void
     */
    public function __construct($user, SearchLocations $searchLocations)
    {
        $this->user = $user;
        $this->searchLocations = $searchLocations;
    }

    /**
     * Build the mail representation of the notification.
     */
    public function build()
    {
        return $this
            ->to($this->user->email)
            ->subject(trans('admin::app.mail.user.register-subject'))
            ->view('admin::emails.users.create', [
                'user_name' => $this->user->name,
            ]);
    }
}