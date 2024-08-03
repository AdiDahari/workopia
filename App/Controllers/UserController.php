<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

class UserController
{
  protected $db;

  public function __construct()
  {
    $config = require basePath('config/db.php');
    $this->db = new Database($config);
  }

  /**
   * Load login page
   * 
   * @return void
   */
  public function login()
  {
    loadView('users/login');
  }

  /**
   * Load register page
   * 
   * @return void
   */
  public function create()
  {
    loadView('users/create');
  }

  /**
   * Store user
   * 
   * @return void
   */
  public function store()
  {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password_confirmation'];

    $errors = [];

    if (!Validation::string($name, 1, 50)) {
      $errors['name'] = 'Name is required and must be less than 50 characters';
    }

    if (!Validation::email($email)) {
      $errors['email'] = 'Email is required';
    }

    if (!Validation::string($password, 6, 50)) {
      $errors['password'] = 'Password must be greater than 6 characters';
    }

    if (!Validation::string($passwordConfirmation)) {
      $errors['password_confirmation'] = 'Password confirmation is required';
    }

    if (!Validation::match($password, $passwordConfirmation)) {
      $errors['password_confirmation'] = 'Passwords do not match';
    }

    if (count($errors) > 0) {
      loadView('users/create', [
        'errors' => $errors,
        'user' => [
          'name' => $name,
          'email' => $email,
          'city' => $city,
          'state' => $state,
          'country' => $country,
        ]
      ]);

      exit;
    }

    // Check if email exists
    $params = [
      'email' => $email
    ];

    $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

    if ($user) {
      $errors['email'] = 'Email already exists';

      loadView('users/create', [
        'errors' => $errors,
        'user' => [
          'name' => $name,
          'city' => $city,
          'state' => $state,
          'country' => $country,
        ]
      ]);

      exit;
    }

    // Create user
    $params = [
      'name' => $name,
      'email' => $email,
      'city' => $city,
      'state' => $state,
      'country' => $country,
      'password' => password_hash($password, PASSWORD_DEFAULT)
    ];


    $this->db->query('INSERT INTO users (name, email, city, state, country, password) VALUES (:name, :email, :city, :state, :country, :password)', $params);

    // Session data
    Session::set('user', [
      'id' => $this->db->conn->lastInsertId(),
      'name' => $name,
      'email' => $email,
      'city' => $city,
      'state' => $state,
      'country' => $country,
    ]);

    redirect("/");
  }

  /**
   * Logout handler
   * 
   * @return void
   */
  public function logout()
  {
    Session::clearAll();

    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

    redirect("/");
  }
}
