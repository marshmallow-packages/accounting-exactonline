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
        $item = $this->getExactOnlineModel();
        return $item->find($this->exact->accounting_id);
    }

    protected function viewOnIndex ()
    {
    	return ['Code', 'ID', 'Name'];
    }
    
    protected function getExactOnlineModel ()
    {
        return new Item(
            $this->exactOnlineConnection()
        );
    }
}