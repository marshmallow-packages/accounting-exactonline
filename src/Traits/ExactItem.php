<?php

namespace Marshmallow\ExactOnline\Traits;

use Picqer\Financials\Exact\Item;
use Marshmallow\ExactOnline\Models\ExactOnlineConnect;

trait ExactItem
{
    public static function bootExactItem()
    {
        //
    }

    public function getDataFromExact ()
    {
        $account = $this->getExactOnlineModel();
        $item = $account->filter("Code eq '" . $this->{$this->exactOnlineIdColumn()} . "'");
        return $this->exactResponseToArray($item);
    }

    protected function viewOnIndex ()
    {
    	return ['ID', 'Name'];
    }
    
    protected function getExactOnlineModel ()
    {
        return new Item(
            $this->exactOnlineConnection()
        );
    }

    protected function exactOnlineIdColumn ()
    {
    	return 'accounting_id';
    }
}