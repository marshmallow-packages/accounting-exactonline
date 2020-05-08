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
        $this->account->syncToAccounting();
    }
}
