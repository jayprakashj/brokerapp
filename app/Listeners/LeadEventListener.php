<?php

namespace App\Listeners;

use App\Mail\LeadGenerateMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class LeadEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
        $lead = $event->lead;
        $company = $lead->company;
        if( $company->isLeadNotificationOn() ){
            $emails = $company->leadEmailsArr();
            $emails[] = $company->email;
            if( $lead->assignToUser ){
                $emails[] = $lead->assignToUser->email;
            }
            $emails = array_filter( $emails );
            $emails = array_unique( $emails );

            $mailObj = new LeadGenerateMail( $lead );

            foreach( $emails as $emailAddress ){
                $tmpMail = clone $mailObj;
                Mail::to( $emailAddress )->send( $tmpMail );
            }
        }
    }
}
