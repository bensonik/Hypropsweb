<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 3/8/2018
 * Time: 9:22 AM
 */

namespace App\Helpers;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use view;
use Illuminate\Support\Facades\Session;
use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\Storage;
use App\Mail\DemoMail;

class Notify
{

    public static function sendMail($viewPage,$arrayContent = [],$email,$fullName = '',$subject = ''){
        /*Mail::send($viewPage, $arrayContent,
            function ($message) use ($email,$fullName,$subject)
            {

                $message->from('info@hyprops.com', 'No Reply');

                $message->to($email)->subject($subject);

            });*/
        //Mail::to($email)->send(new DemoMail($arrayContent));
    }

    public static function appraisalMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new DemoMail($objContent));
    }

    public static function leaveRequestMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new LeaveRequestMail($objContent));
    }

    public static function payrollMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new PayrollMail($objContent));
    }

    public static function poMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new PoMail($objContent));
    }

    public static function rfqMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new rfqMail($objContent));
    }

    public static function warehouseMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        //Mail::to($email)->send(new WarehouseMail($objContent));
    }


}