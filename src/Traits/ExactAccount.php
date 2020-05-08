<?php

namespace Marshmallow\ExactOnline\Traits;

use Picqer\Financials\Exact\Account;
use Marshmallow\ExactOnline\Models\ExactOnlineConnect;
use Marshmallow\ExactOnline\Jobs\CreateAccountInExactOnline;

trait ExactAccount
{
	public static function bootExactAccount()
    {
    	// static::created(function($account) {
     //    	CreateAccountInExactOnline::dispatch($account);
     //    });
    }

    public function syncToAccounting ()
    {
        /**
         * Maak de prospect aan
         */
        $account = $this->getExactOnlineModel();
        foreach ($this->exactOnlineMapping() as $key => $value) {
            $account->{$key} = $value;
        }
        $account = $account->save();

        /*
         * Sla het ID van Exact Online op in de database
         */
        $this->exact()->create([
            'accounting_id' => $account->ID,
            'accounting_last_sync' => now(),
        ]);

        
        /**
         * Maak een contact aan die we koppelen aan de prospect
         */
        $contact = new \Picqer\Financials\Exact\Contact($this->exactOnlineConnection());
        $contact->Account = $account->ID;
        foreach ($this->exactOnlineContactMapping() as $key => $value) {
            $contact->{$key} = $value;
        }
        $contact->save();
    }

    public function getDataFromExact ()
    {
        $account = $this->getExactOnlineModel();
        return $account->find($this->exact->accounting_id);
    }

    protected function viewOnIndex ()
    {
        return ['ID', 'Name'];
    }

    protected function getExactOnlineModel ()
    {
        return new Account(
            $this->exactOnlineConnection()
        );
    }

    abstract function exactOnlineMapping();
    abstract function exactOnlineContactMapping();
}