<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Helpers\Utility;
use App\Mail\ReorderMail;
use Illuminate\Support\Facades\Mail;

class InventoryReorderLevel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Inventory:reorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to Inventory Users when inventory item is low';

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
        $inventoryUsers = DB::table('inventory_access')
            ->where('inventory_access.status', Utility::STATUS_ACTIVE)
            ->join('users', 'users.id', '=', 'inventory_access.user_id')
            ->orderBy('inventory_access.id','DESC')->get();
        //$inventoryUsers = Utility::getAllData('inventory_access');

        $inventoryItems = Utility::getAllData('inventory');
        if(!empty($inventoryItems)){
            foreach($inventoryItems as $item){
                if($item->re_order_level >= $item->qty){
                    if(!empty($inventoryUsers)){
                        foreach ($inventoryUsers as $user){
                            $emailContent = new \stdClass();
                            $emailContent->name = $user->firstname.' '.$user->lastname;
                            $emailContent->item = $item->name;
                            $emailContent->qty = $item->qty;
                            $emailContent->re_order_level = $item->re_order_level;
                            Mail::to($user->email)->send(new ReorderMail($emailContent));

                        }
                    }
                }
            }
        }



    }
}