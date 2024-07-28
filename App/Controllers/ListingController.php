<?php

namespace App\Controllers;

use Framework\Database;

class ListingController
{
  protected $db;

  public function __construct()
  {
    // Database configuration
    $config = require basePath("config/db.php");
    $this->db = new Database($config);
  }

  /**
   * Retrieve listings from database and load them 
   * within the listings index view
   *
   * @return void
   */
  public function index()
  {
    // Query for all of the listings
    $listings = $this->db->query("SELECT * FROM listings")->fetchAll();

    // Loading the view while providing the listings data.
    loadView('listings/index', [
      'listings' => $listings,
    ]);
  }

  /**
   * Listing creation handler.
   * Loads the creation form
   *
   * @return void
   */
  public function create()
  {
    loadView('listings/create');
  }

  /**
   * Single listing information page handler
   *
   * @param array $params
   * @return void
   */
  public function show($params)
  {
    $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetchObject();

    if (!$listing) {
      ErrorController::notFound("Listing not found");
      return;
    }

    loadView('listings/show', [
      'listing' => $listing,
    ]);
  }
}
