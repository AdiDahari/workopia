<?php

namespace Framework\Middleware;

use Framework\Session;

class Authorize
{


  public function isAuthenticated()
  {
    return Session::has('user');
  }

  /**
   * Handle the request
   * 
   * @param string $role
   * @return bool
   */
  public function handle($role)
  {
    if ($role === 'guest' && $this->isAuthenticated()) {
      return redirect('/');
    } else if ($role === 'auth' && !$this->isAuthenticated()) {
      return redirect('/auth/login');
    }
  }
}
