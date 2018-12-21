<?php

namespace RobertHucks\SelfDestruct\Console;

use App\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use RobertHucks\SelfDestruct\Models\Destructor;
use Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);

        $schedule->call(function () {
            $models = Destructor::whereTime('ttl', '<=', new \DateTime())->get();
            foreach($models as $model) {
                $model->deletable_type::find($model->deletable_id)->delete();
                $model->delete();
            }
        })->everyMinute();
    }
}