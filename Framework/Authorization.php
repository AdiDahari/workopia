<?php

namespace Framework;

class Authorization
{

  /**
   * Check if a user is the owner of a listing
   * 
   * @param int $resourceOwnerId
   * @return bool
   */
  public static function isOwner($resourceOwnerId)
  {
    $user = Session::get('user');

    if ($user !== null && isset($user['id'])) {
      $userId = (int) $user['id'];

      return $userId === $resourceOwnerId;
    }

    return false;
  }
}
