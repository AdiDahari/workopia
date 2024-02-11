<?php

class Router
{
  protected $routes = [];

  /**
   * Register a new Route to the router.
   *
   * @param string $method
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function registerRoutes($method, $uri, $controller)
  {
    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controller' => $controller
    ];
  }

  /**
   * Load error page if route not found.
   * 
   * @param int $httpCode
   * 
   * @return void
   */
  public function error($httpCode = 404)
  {
    http_response_code($httpCode);
    loadView("error/{$httpCode}");
    exit;
  }

  /**
   * Route the request to the appropriate controller.
   * 
   * @param string $uri
   * @param string $method
   * 
   * @return void
   */
  public function route($uri, $method)
  {
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === $method) {
        require basePath($route['controller']);
        return;
      }
    }
    $this->error();
  }

  /**
   * Add a new GET route to the router.
   * 
   * @param string $uri
   * @param string $controller
   * 
   * @return void
   */
  public function get($uri, $controller)
  {
    $this->registerRoutes('GET', $uri, $controller);
  }
  /**
   * Add a new POST route to the router.
   * 
   * @param string $uri
   * @param string $controller
   * 
   * @return void
   */
  public function post($uri, $controller)
  {
    $this->registerRoutes('POST', $uri, $controller);
  }
  /**
   * Add a new PUT route to the router.
   * 
   * @param string $uri
   * @param string $controller
   * 
   * @return void
   */
  public function put($uri, $controller)
  {
    $this->registerRoutes('PUT', $uri, $controller);
  }
  /**
   * Add a new DELETE route to the router.
   * 
   * @param string $uri
   * @param string $controller
   * 
   * @return void
   */
  public function delete($uri, $controller)
  {
    $this->registerRoutes('DELETE', $uri, $controller);
  }
}
