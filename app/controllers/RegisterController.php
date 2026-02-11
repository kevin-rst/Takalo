<?php

namespace app\controllers;

use app\repositories\UserRolesRepository;
use flight\Engine;
use app\services\Validator;
use app\repositories\UsersRepository;
use app\services\UsersService;

class RegisterController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function showRegister()
    {
        $this->app->render('auth/register', [
            'values' => ['nom' => '', 'email' => ''],
            'errors' => ['password' => '', 'confirm_password' => ''],
            'success' => false,
        ]);
    }

    public function postRegister()
    {
        $pdo  = $this->app->db();
        $repo = new UsersRepository($pdo);
        $roleRepo = new UserRolesRepository($pdo);
        $svc  = new UsersService($repo);

        $req = $this->app->request();

        $input = [
            'nom' => $req->data->nom,
            'email' => $req->data->email,
            'password' => $req->data->password,
            'confirm_password' => $req->data->confirm_password,
        ];

        $res = Validator::validateRegister($input, $repo);

        if ($res['ok']) {
            $role = $roleRepo->getRole('user')['id'];
            $svc->register($res['values'], (string)$input['password'], $role);

            if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}

			$user = $repo->getUser($res['values']['nom']);
			$_SESSION['users']['id'] = $user['id'];
			$_SESSION['users']['username'] = $user['username'];

            $this->app->redirect('/frontoffice');
            return;
        }

        $this->app->render('auth/register', [
            'values' => $res['values'],
            'errors' => $res['errors'],
            'success' => false
        ]);
    }
}
