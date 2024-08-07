<?php

namespace Framework;

class Session
{
  /**
   * Starts session
   * 
   * @return void
   */
  public static function start()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
  }

  /**
   * Set session key/value
   * 
   * @param string $key
   * @param mixed $value
   * @return void
   */
  public static function set($key, $value)
  {
    $_SESSION[$key] = $value;
  }

  /**
   * Get session value by key
   * 
   * @param string $key
   * @param mxied $default
   * @return mixed
   */
  public static function get($key, $default = null)
  {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
  }

  /**
   * Check if session key exists
   * 
   * @param string $key
   * @return bool
   */
  public static function has($key)
  {
    return isset($_SESSION[$key]);
  }

  /**
   * Clear session by key
   * 
   * @param string $key
   * @return void
   */
  public static function clear($key)
  {
    unset($_SESSION[$key]);
  }

  /**
   * Clear all session data
   * 
   * @return void
   */
  public static function clearAll()
  {
    session_unset();
    session_destroy();
  }

  /**
   * Set flash message
   * 
   * @param string $key
   * @param string $message
   * @return void
   */
  public static function setFlashMessage($key, $message)
  {
    self::set("flash_{$key}", $message);
  }

  /**
   * Get flash message
   * 
   * @param string $key
   * @param mixed $default
   * @return string
   */
  public static function getFlashMessage($key, $default = null)
  {
    $message = self::get("flash_{$key}", $default);

    self::clear("flash_{$key}");

    return $message;
  }
}
