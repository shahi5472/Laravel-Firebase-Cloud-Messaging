<?php

namespace App\Console\Commands;

use App\Http\Controllers\FCMNotificationController;
use Illuminate\Console\Command;
use Illuminate\Routing\Route;

class DailyFCMNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fcm_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily Send FCM Notification';

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
     * @return int
     */
    public function handle()
    {
        FCMNotificationController::sendNotification();
        echo 'FCM Notification Send';
        return 0;
    }
}
