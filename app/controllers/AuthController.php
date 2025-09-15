<?php

namespace BaseApp\Controller;

use Stilmark\Base\Env;
use Stilmark\Base\Auth;
use Stilmark\Base\Controller;

use BaseApp\Model\User;
use BaseApp\Model\AuthIdentities;

class AuthController extends Controller
{
    private string $authSessionName;

    protected function initialize(): void
    {
        $this->authSessionName = Env::get('AUTH_SESSION_NAME', 'auth');
    }

    public function callout(string $provider) {
        $auth = new Auth($provider);
        $auth->callout();
    }

    public function callback(string $provider) {
        try {
            $auth = new Auth($provider);
            $tokenData = $auth->callback($this->request);

            if (isset($tokenData['status']) && $tokenData['status'] === 'error') {
                $this->json($tokenData, 400);
            } else {

                // Todo: replace
                $tokenData['provider_type'] = 'google';
                
                $identity = AuthIdentities::get([
                    'provider_type' => $tokenData['provider_type'],
                    'provider_subject' => $tokenData['user']['sub']
                ]);

                if ($identity) {
                    $user = User::get($identity['user_id']);

                    $this->json([
                        'status' => 'success',
                        'user' => $user,
                        'identity' => $identity
                    ]);

                } else {

                    // Check if user with email exists?
                    $user = User::get([
                        'email' => $tokenData['user']['email']
                    ]);

                    if (!$user) {
                        $user = User::set([
                            'email' => $tokenData['user']['email'],
                            'email_verified' => $tokenData['user']['email_verified'],
                            'first_name' => $tokenData['user']['given_name'],
                            'last_name' => $tokenData['user']['family_name'],
                            'picture_url' => $tokenData['user']['picture'],
                            'status' => 'active',
                            'last_login_at' => 'NOW()'
                        ])->create();
                    }

                    $identity = AuthIdentities::set([
                        'user_id' => $user['id'] ?? null,
                        'provider_type' => $tokenData['provider_type'],
                        'provider_subject' => $tokenData['user']['sub'],
                        'email' => $tokenData['user']['email'],
                        'email_verified' => $tokenData['user']['email_verified'],
                        'hd_domain' => $tokenData['user']['hd'] ?? $this->getDomainFromEmail($tokenData['user']['email']),
                        'last_login_at' => 'NOW()'
                    ])->create();

                }

                $this->json([
                    'status' => 'success',
                    'tokenData' => $tokenData,
                    'session' => $_SESSION[$this->authSessionName],
                    'identity' => $identity
                ]);

            }
        } catch (\InvalidArgumentException $e) {
            $this->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            $this->json([
                'status' => 'error',
                'message' => 'Authentication failed: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getDomainFromEmail(string $email): string {
        return explode('@', $email)[1];
    }

    public function logout() {
        $auth = new Auth();
        $auth->logout();
        $this->json([
            'status' => 'success'
        ]);
    }
}