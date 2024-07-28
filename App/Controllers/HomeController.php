<?php

namespace App\Controllers;

use Framework\Database;

class HomeController
{
  protected $db;

  public function __construct()
  {
    // Database configuration
    $config = require basePath("config/db.php");
    $this->db = new Database($config);
  }

  /**
   * Home route handler
   *
   * @return void
   */
  public function index()
  {
    // Fetch 6 of the listings and load into the view
    $listings = $this->db->query("SELECT * FROM listings LIMIT 6")->fetchAll();

    loadView('home', [
      'listings' => $listings,
    ]);
  }
}
