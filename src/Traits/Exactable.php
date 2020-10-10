<?php

namespace Marshmallow\ExactOnline\Traits;

use Marshmallow\ExactOnline\Models\ExactOnlineConnect;
use Marshmallow\ExactOnline\Models\ExactOnlineData;

trait Exactable
{
    public function exact()
    {
        return $this->morphOne(ExactOnlineData::class, 'exactable');
    }

    public function getExactModelFields()
    {
        return $this->viewOnIndex();
    }

    public function exactOnlineConnection()
    {
        return ExactOnlineConnect::connect();
    }

    public function exactResponseToArray(array $item)
    {
        if (! $item) {
            return [];
        }
        $item = $item[0];

        if (! $item instanceof \Picqer\Financials\Exact\Model) {
            throw new Exception("The returned object is not an ExactOnline model.");
        }

        if (! $this->exact()->where('accounting_id', $item->ID)->get()->first()) {
            $this->exact()->create([
                'accounting_id' => $item->ID,
                'accounting_last_sync' => now(),
            ]);
        }

        return json_decode($item->json(), true);
    }
}
