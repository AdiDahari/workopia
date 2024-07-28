<?php

namespace Framework;

class Router
{
  protected $routes = [];

  /**
   * Register a route with a method
   *
   * @param string $method
   * @param string $uri
   * @param string $action
   * @return void
   */
  private function registerRoute($method, $uri, $action)
  {

    list($controller, $controllerMethod) = explode('@', $action);

    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controller' => $controller,
      'controllerMethod' => $controllerMethod,
    ];
  }

  /**
   * GET route handler
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function get($uri, $controller)
  {
    $this->registerRoute('GET', $uri, $controller);
  }

  /**
   * POST route handler
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function post($uri, $controller)
  {
    $this->registerRoute('POST', $uri, $controller);
  }

  /**
   * PUT route handler
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function put($uri, $controller)
  {
    $this->registerRoute('PUT', $uri, $controller);
  }

  /**
   * DELETE route handler
   *
   * @param string $uri
   * @param string $controller
   * @return void
   */
  public function delete($uri, $controller)
  {
    $this->registerRoute('DELETE', $uri, $controller);
  }

  /**
   * Error handler
   *
   * @param int $statusCode
   * @return void
   */
  public function error($statusCode = 404)
  {
    http_response_code($statusCode);
    loadView('error/' . $statusCode);
    exit;
  }


  /**
   * Route requests
   *
   * @param string $uri
   * @param string $method
   * @return void
   */
  public function route($uri, $method)
  {
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['method'] === $method) {
        // Extract controller and controller method
        $controller = new ('App\\controllers\\' . $route['controller'])();
        $controllerMethod = $route['controllerMethod'];

        // init controller and call method

        // $controllerInstance = new $controller();
        $controller->$controllerMethod();
        return;
      }
    }

    $this->error();
  }
}
