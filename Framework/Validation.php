<?php

namespace Framework;

class Validation
{

  /**
   * Validate string value
   * 
   * @param string $value
   * @param int $min
   * @param int $max
   * @return boolean
   */
  public static function string($value, $min = 1, $max = INF)
  {
    if (is_string($value)) {
      $value = trim($value);
      $length = strlen($value);

      return $length <= $max && $length >= $min;
    }

    return false;
  }

  /**
   * Validate email address
   * 
   * @param string $value
   * @return string|false
   */
  public static function email($value)
  {
    $value = trim($value);

    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  /**
   * Match 2 values
   * 
   * @param string $value1
   * @param string $value2
   * @return bool
   */
  public static function match($value1, $value2)
  {
    $value1 = trim($value1);
    $value2 = trim($value2);

    return $value1 === $value2;
  }
}
