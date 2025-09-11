<?php
namespace BaseApp\Controller;

use Stilmark\Base\Controller;
use BaseApp\Model\User;

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