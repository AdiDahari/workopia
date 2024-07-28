<?php

namespace App\Controllers;

class ErrorController
{

  /**
   * 404 - Not found handler
   *
   * @param string $message
   * @return void
   */
  public static function notFound($message = "Resource not found")
  {
    http_response_code(404);

    loadView('error', [
      "status" => "404",
      "message" => $message,
    ]);
  }

  /**
   * 403 - Forbidden handler
   *
   * @param string $message
   * @return void
   */
  public static function forbidden($message = "Resource not available")
  {
    http_response_code(403);

    loadView('error', [
      "status" => "403",
      "message" => $message,
    ]);
  }

  /**
   * 401 - Unauthorized handler
   *
   * @param string $message
   * @return void
   */
  public static function unauthorized($message = "Resource is limited to authorized users only")
  {
    http_response_code(401);

    loadView('error', [
      "status" => "401",
      "message" => $message,
    ]);
  }
}
