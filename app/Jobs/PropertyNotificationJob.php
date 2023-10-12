<?php

namespace App\Jobs;

use App\Mail\PropertyNotificationMail;
use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PropertyNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $company = \Helper::retrieveDefaultCompany();
        if( $company->isPropertyNotificationOn() ){

            $lists = Property::with('assignToUser')
                                ->filterByNotificationDate()
                                ->get();

            foreach( $lists as $item ){

                $emails = $company->propertyEmailsArr();

                $emails[] = $company->email;
                if( $item->assignToUser ){
                    $emails[] = $item->assignToUser->email;
                }

                $emails = array_filter( $emails );
                $emails = array_unique( $emails );

                $mailObj = new PropertyNotificationMail( $item );

                foreach( $emails as $emailAddress ){
                    $tmpMail = clone $mailObj;
                    Mail::to( $emailAddress )->send( $tmpMail );
                }
            }
        }
    }
}
