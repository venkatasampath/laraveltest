<?php

namespace App\Providers;

use App\Http\Requests\Validation;
use Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Laravel\Horizon\Horizon;
use Log;
use Queue;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        if (config('app.env') === 'production') {
//            Log::info(__METHOD__.' in ENV='.config('app.env')." URL::forceScheme to HTTPS");
//            URL::forceScheme('https');
//        }
        Validator::resolver(function($translator, $data, $rules, $messages)
        {
            return new Validation($translator, $data, $rules, $messages);
        });

        //
        /**
         * Authenticate Horizon if using in local/development environment
         * or only for admins in other environments (cat/production)
         */
        Horizon::auth(function ($request) {
            if (config('app.env') === 'local') { // Always show if local development
                return true;
            } else { // show if user is admin in other environments
                if (Auth::check()) {
                    return Auth::user()->hasRole('admin');
                }
            }
            return false;
        });

        /**
         * Blade directive to convert UTC timestamps to users default timezone timestamps
         */
        Blade::directive('cora_converttime', function($timestamp) {
            return "<?php echo \Carbon\Carbon::parse($timestamp)->timezone(Auth::user()->default_timezone)->toDateTimeString()?>";
        });

        /**
         * Job dispatched & processing
         */
//        Queue::before(function ( JobProcessing $event ) {
//            Log::info(__METHOD__.' Job ready: ' . $event->job->resolveName());
//        });

        /**
         * Job processed
         */
//        Queue::after(function ( JobProcessed $event ) {
//            Log::notice(__METHOD__.' Job done: ' . $event->job->resolveName());
//        });

        /**
         * Job failed
         */
//        Queue::failing(function ( JobFailed $event ) {
//            Log::error(__METHOD__.' Job failed: ' . $event->job->resolveName() . '(' . $event->exception->getMessage() . ')');
//
//            $eventData = [];
//            $eventData['connectionName'] = $event->connectionName;
//            $eventData['job'] = $event->job->resolveName();
//            $eventData['queue'] = $event->job->getQueue();
//            $eventData['exception'] = [];
//            $eventData['exception']['message'] = $event->exception->getMessage();
//            $eventData['exception']['file'] = $event->exception->getFile();
//            $eventData['exception']['line'] = $event->exception->getLine();
//
//            // Get some details about the failed job
//            $job = unserialize($event->job->payload()['data']['command']);
//            if (property_exists($job, 'order')) {
//                $eventData['id'] = $job->order->id;
//                $eventData['name'] = $job->order->name;
//            }
//
//            // Send slack notification of the failed job
//            Notification::route('slack', env('SLACK_WEBHOOK'))->notify(new JobFailedNotification($eventData));
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Add Service providers for automated testing
        if ($this->app->environment('testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        // Add Service providers for production environments only
        if ($this->app->environment('production') || $this->app->environment('cat')) {
            $this->app->register(PaperTrailServiceProvider::class);
        }
    }
}
