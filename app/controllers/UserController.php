<?php
namespace BaseApp\Controller;

use BaseApp\Model\User;
use Stilmark\Base\Controller;

final class UserController extends Controller
{
    public function index(int $id): array
    {
        $user = User::get($id);
        $this->json([
            'status' => 'ok', 
            'user' => $user
        ]);
    }
}