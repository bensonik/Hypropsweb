<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\User;
use Illuminate\Console\Command;

class Birthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out email to users who have birthday, and notifies people of other peoples birthday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $today = date('Y-m-d');
        $birthdayUsersArr = [];
        $birthdayNames = [];
        $birthdayUsers =  User::specialColumns2('active_status',Utility::STATUS_ACTIVE,'dob',$today);
        foreach ($birthdayUsers as $userData){

            $birthdayUsersArr[] = $userData->id;
            $userEmail = $userData->email;
            $names = $userData->firstname.' '.$userData->lastname;
            $birthdayNames[] = $names;

            $mailContent = [];

            $messageBody = "Dear " . $userData->firstname . ", we realize how important today is to you.
            Birthdays comes once in a year, so we celebrate you today. Happy birthday, and have an amazing year.
            From ".Utility::companyInfo()->name;

            $mailContent['message'] = $messageBody;
            Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);

        }

        $activeUsers = User::getAllData();
        foreach($activeUsers as $userData){
            if(!in_array($userData->id,$birthdayUsersArr)){
                $userEmail = $userData->email;

                $mailContent = [];

                $messageBody = "Dear " . $userData->firstname . ", ".implode(',',$birthdayNames).
                " have birthday today, please wish them well";

                $mailContent['message'] = $messageBody;
                Notify::GeneralMail('mail_views.general', $mailContent, $userEmail);
            }
        }


    }
}
