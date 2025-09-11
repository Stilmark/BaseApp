<?php

namespace BaseApp\Controller;

use Stilmark\Base\Auth;
use Stilmark\Base\Controller;

class AuthController extends Controller
{
    private Auth $auth;

    protected function initialize(): void
    {
        $this->auth = new Auth();
    }

    public function callout() {
        $this->auth->callout();
    }

    public function callback() {
        try {
            $tokenData = $this->auth->callback($this->request);
            if (isset($tokenData['status']) && $tokenData['status'] === 'error') {
                $this->json($tokenData, 400);
            } else {
                $this->json([
                    'status' => 'success',
                    'data' => $tokenData
                ]);
            }
        } catch (\Exception $e) {
            $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}