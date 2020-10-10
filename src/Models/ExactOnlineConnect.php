<?php

namespace Marshmallow\ExactOnline\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Picqer\Financials\Exact\Connection;

class ExactOnlineConnect extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'access_token',
        'refresh_token',
        'token_expires',
    ];

    public static function setup()
    {
        $connection = new \Picqer\Financials\Exact\Connection();
        $connection->setRedirectUrl(env('EXACT_ONLINE_REDIRECT_URI')); // Same as entered online in the App Center
        $connection->setExactClientId(env('EXACT_ONLINE_CLIENT_ID'));
        $connection->setExactClientSecret(env('EXACT_ONLINE_CLIENT_SECRET'));

        return $connection;
    }

    public static function connect()
    {
        $connection_auth = self::get()->first();
        if (! $connection_auth) {
            throw new Exception('No tokens available available');
        }

        $connection = self::setup();
        $connection->setAccessToken($connection_auth->access_token);
        $connection->setRefreshToken($connection_auth->refresh_token);
        $connection->setTokenExpires(Carbon::parse($connection_auth->token_expires)->timestamp);
        $connection->connect();

        self::storeTokenInformation($connection);

        return $connection;
    }

    public static function storeTokenInformation(Connection $connection)
    {
        self::truncate();

        return self::create([
            'access_token' => $connection->getAccessToken(),
            'refresh_token' => $connection->getRefreshToken(),
            'token_expires' => Carbon::parse($connection->getTokenExpires()),
        ]);
    }

    public function getAccessToken()
    {
        return $this->access_token;
    }
}
