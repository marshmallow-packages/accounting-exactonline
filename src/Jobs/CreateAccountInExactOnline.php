<?php

namespace Marshmallow\ExactOnline\Jobs;

use Illuminate\Bus\Queueable;
use Picqer\Financials\Exact\Account;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Marshmallow\ExactOnline\Helpers\ConfigHelper;
use Marshmallow\ExactOnline\Helpers\MappingHelper;
use Marshmallow\ExactOnline\Models\ExactOnlineConnect;

class CreateAccountInExactOnline implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $account;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($account)
    {
        $this->account = $account;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * Maak de prospect aan
         */
        $connection = ExactOnlineConnect::connect();
        $account = new Account($connection);
        foreach ($this->account->exactOnlineMapping() as $key => $value) {
            $account->{$key} = $value;
        }
        $account = $account->save();

        /*
         * Sla het ID van Exact Online op in de database
         */
        $this->account->exact()->create([
            'accounting_id' => $account->ID,
            'accounting_last_sync' => now(),
        ]);

        
        /**
         * Maak een contact aan die we koppelen aan de prospect
         */
        $contact = new \Picqer\Financials\Exact\Contact($connection);
        $contact->Account = $account->ID;
        foreach ($this->account->exactOnlineContactMapping() as $key => $value) {
            $contact->{$key} = $value;
        }
        $contact->save();
    }
}
