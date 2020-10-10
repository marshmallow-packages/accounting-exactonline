<?php

namespace Marshmallow\ExactOnline\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Marshmallow\ExactOnline\Models\ExactOnlineConnect;

class AuthenticationController extends Controller
{
    public function connected(Request $request)
    {
        try {
            $me = self::me($request);
            $connected = $me->getData()->success;
        } catch (Exception $e) {
            $connected = false;
        }

        return response()->json([
            'connected' => $connected,
        ]);
    }

    public function authenticate(Request $request)
    {
        return response()->json([
            'auth_url' => ExactOnlineConnect::setup()->getAuthUrl(),
        ]);
    }

    public function disconnect(Request $request)
    {
        $connection_auth = ExactOnlineConnect::get()->first();
        if (! $connection_auth) {
            throw new Exception('Er is geen verbinding om te verbreken');
        }
        ExactOnlineConnect::truncate();

        return response()->json([
            'success' => true,
        ]);
    }

    public function validateConnection(Request $request)
    {
        $connection = ExactOnlineConnect::setup();
        $connection->setAuthorizationCode($request->code);

        try {
            $connection->connect();
            $connection_auth = ExactOnlineConnect::storeTokenInformation($connection);

            return response()->json([
                'access_token' => $connection_auth->getAccessToken(),
            ]);
        } catch (Exception $e) {
            throw new Exception('Could not connect to Exact: ' . $e->getMessage());
        }
    }

    public function me(Request $request)
    {
        try {
            $connection = ExactOnlineConnect::connect();
            $me = new \Picqer\Financials\Exact\User($connection);

            if (! $me) {
                throw new Exception("User not found", 1000);
            }
            if (! $me->get()) {
                throw new Exception("User not found", 1001);
            }
            if (! isset($me->get()[0])) {
                throw new Exception("User not found", 1002);
            }

            $user = $me->get()[0];

            return response()->json([
                'success' => true,
                'user' => $user,
                'visible_user_fields' => config('exactonline.visible_user_fields'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
