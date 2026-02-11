<?php

namespace app\controllers;

use app\repositories\UserRolesRepository;
use flight\Engine;
use app\services\Validator;
use app\repositories\UsersRepository;

class LoginController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function showLogin()
	{
		$this->app->render('auth/login', [
			'values' => ['nom' => ''],
			'errors' => ['password' => '', 'confirm_password' => ''],
			'success' => false,
		]);
	}

	public function postLogin()
	{
		$pdo = $this->app->db();
		$repo = new UsersRepository($pdo);
		$roleRepo = new UserRolesRepository($pdo);

		$req = $this->app->request();

		$input = [
			'nom' => $req->data->nom,
			'password' => $req->data->password,
			'confirm_password' => $req->data->confirm_password,
		];

		$res = Validator::validateLogin($input, $repo);

		if ($res['ok']) {
			$userRole = $roleRepo->getRole('user')['id'];

			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}

			$user = $repo->getUser($res['values']['nom']);
			$_SESSION['users']['id'] = $user['id'];
			$_SESSION['users']['username'] = $user['username'];

			if ($user['id_role'] == $userRole) {
				$url = '/frontoffice';
			} else {
				$url = '/backoffice';
			}

			$this->app->redirect($url);
			return;
		}

		$this->app->render('auth/login', [
			'values' => $res['values'],
			'errors' => $res['errors'],
			'success' => false
		]);
	}

	public function logout() {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		session_destroy();
		$this->app->redirect('/register');
	}
}
