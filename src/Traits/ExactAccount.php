<?php

namespace Marshmallow\ExactOnline\Traits;

use Picqer\Financials\Exact\Account;
use Marshmallow\ExactOnline\Models\ExactOnlineConnect;
use Marshmallow\ExactOnline\Jobs\CreateAccountInExactOnline;

trait ExactAccount
{
	public static function bootExactAccount()
    {
    	static::created(function($account) {
        	CreateAccountInExactOnline::dispatch($account);
        });
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