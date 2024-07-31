<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

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

  /**
   * Store data in database
   * 
   * @return void
   */
  public function store()
  {
    $allowedFields = [
      "title", "description", "salary", "requirements", "benefits", "tags", "company", "address", "city", "state", "country", "phone", "email"
    ];

    $data = array_intersect_key($_POST, array_flip($allowedFields));
    $data['user_id'] = 1;

    $data = array_map('sanitize', $data);

    $requiredFields = [
      "title", "description", "salary", "city", "state", "country", "email"
    ];
    $errors = [];

    foreach ($requiredFields as $field) {
      if (!trim($data[$field])) {
        $errors[$field] = ucfirst($field) . " is required";
      }
    }

    if (!empty($errors)) {
      loadView('listings/create', [
        'errors' => $errors,
        'listing' => $data,
      ]);
    } else {
      // $this->db->query('INSERT INTO listings 
      //   (title, description, salary, requirements, benefits, company, address, city, state, country, phone, email)
      //   VALUES (:title, :description, :salary, :requirements, :benefits, 
      //     :company, :address, :city, :state, :country, :phone, :email)', $data);

      $fields = [];
      $values = [];
      foreach ($data as $field => $value) {
        $fields[] = $field;
        if ($value === '') {
          $data[$field] = null;
        }
        $values[] = ':' . $field;
      }

      $fields = implode(", ", $fields);
      $values = implode(", ", $values);

      $query = "INSERT INTO listings ({$fields}) VALUES ($values)";

      $this->db->query($query, $data);

      redirect("/listings");
    }
  }
}
