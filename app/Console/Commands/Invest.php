<?php

namespace App\Console\Commands;

use App\Binary;
use App\Model\Bonus;
use App\Model\Investment;
use App\Model\VocerPoint;
use App\User;
use Illuminate\Console\Command;

class Invest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:invest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this comment runs once a day. to run an investment once a day';

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
        $profit = 0.01;
        $user = User::all();
        $user->map(function ($item) use ($profit) {
            if ($item->status == 1) {
                $getJoinUser = Investment::where('user', $item->id)->orderBy('id', 'desc')->first();
                $vocerPointLimit = VocerPoint::where('user', $item->id)->sum('credit') - VocerPoint::where('user', $item->id)->sum('debit');
                if ($vocerPointLimit > 0) {
                    $bonus = new Bonus();
                    $bonus->description = "ROI";
                    $bonus->invest_id = $getJoinUser->reinvest;
                    $bonus->user = $item->id;
                    $bonus->credit = $getJoinUser->join * $profit;
                    $bonus->status = 2;
                    $bonus->save();

                    $vocerPoint = new VocerPoint();
                    $vocerPoint->description = "ROI";
                    $vocerPoint->bonus_id = $getJoinUser->reinvest;
                    $vocerPoint->user = $item->id;
                    $vocerPoint->debit = $getJoinUser->join * $profit;
                    $vocerPoint->status = 2;
                    $vocerPoint->save();

                    if (($getJoinUser->profit + ($getJoinUser->join * $profit)) >= $getJoinUser->package) {
                        $getJoinUser->status = 1;
                        $binary = Binary::where('user', $item->id)->first();
                        $binary->invest = 0;
                        $binary->save();
                    }
                    $getJoinUser->profit = $getJoinUser->profit + ($getJoinUser->join * $profit);
                    $getJoinUser->save();
                }
            }
            return $item;
        });

        $this->info('daily send investment');
    }
}
