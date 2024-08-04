<?php

namespace App\Controllers;

use Framework\Authorization;
use Framework\Database;
use Framework\Session;
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
    $listings = $this->db->query("SELECT * FROM listings ORDER BY created_at DESC")->fetchAll();

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
    $data['user_id'] = Session::get('user')['id'];

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

      Session::setFlashMessage('success', 'Listing created successfully');


      redirect("/listings");
    }
  }

  /**
   * Delete listing from database
   * 
   * @param array $params
   * @return void
   */
  public function destroy($params)
  {
    $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

    if (!$listing) {
      ErrorController::notFound("Listing not found");
      return;
    }

    // Authorize user
    if (!Authorization::isOwner($listing->user_id)) {
      Session::setFlashMessage('error', 'You are not authorized to delete this listing');

      redirect("/listings/" . $listing->id);
    }

    $this->db->query('DELETE FROM listings WHERE id = :id', $params);

    // Set flash message
    Session::setFlashMessage('success', 'Listing deleted successfully');

    redirect("/listings");
  }

  /**
   * Listing edit handler.
   * Loads the creation form
   *
   * @param array $params
   * @return void
   */
  public function edit($params)
  {
    $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetchObject();

    if (!$listing) {
      ErrorController::notFound("Listing not found");
      return;
    }

    // Authorize user
    if (!Authorization::isOwner($listing->user_id)) {
      Session::setFlashMessage('error', 'You are not authorized to edit this listing');

      redirect("/listings/" . $listing->id);
    }

    loadView('listings/edit', [
      'listing' => $listing,
    ]);
  }

  /**
   * Persist an updated listing
   * 
   * @param array $params
   * @return void
   */
  public function update($params)
  {
    $listing = $this->db->query("SELECT * FROM listings WHERE id = :id", $params)->fetchObject();

    if (!$listing) {
      ErrorController::notFound("Listing not found");
      return;
    }

    $allowedFields = [
      "title", "description", "salary", "requirements", "benefits", "tags", "company", "address", "city", "state", "country", "phone", "email"
    ];

    $updateData = array_intersect_key($_POST, array_flip($allowedFields));

    $updateData = array_map('sanitize', $updateData);

    $requiredFields = [
      "title", "description", "salary", "city", "state", "country", "email"
    ];
    $errors = [];

    foreach ($requiredFields as $field) {
      if (!trim($updateData[$field])) {
        $errors[$field] = ucfirst($field) . " is required";
      }
    }

    if (!empty($errors)) {
      loadView('listings/edit', [
        'errors' => $errors,
        'listing' => $updateData,
      ]);
      exit;
    } else {

      $updateFields = [];

      foreach (array_keys($updateData) as $field) {
        $updateFields[] = "{$field} = :{$field}";
      }
      $updateFields = implode(", ", $updateFields);

      $query = "UPDATE listings SET $updateFields WHERE id = :id";

      $updateData["id"] = $listing->id;
      $this->db->query($query, $updateData);

      Session::setFlashMessage('success', 'Listing updated successfully');


      redirect('/listings/' . $listing->id);
    }
  }
}
