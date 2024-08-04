<?php

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

class Router
{
  protected $routes = [];

  /**
   * Register a route with a method
   *
   * @param string $method
   * @param string $uri
   * @param string $action
   * @param array $middleware
   * @return void
   */
  private function registerRoute($method, $uri, $action, $middleware = [])
  {

    list($controller, $controllerMethod) = explode('@', $action);

    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controller' => $controller,
      'controllerMethod' => $controllerMethod,
      'middleware' => $middleware,
    ];
  }

  /**
   * GET route handler
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */
  public function get($uri, $controller, $middleware = [])
  {
    $this->registerRoute('GET', $uri, $controller, $middleware);
  }

  /**
   * POST route handler
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */
  public function post($uri, $controller, $middleware = [])
  {
    $this->registerRoute('POST', $uri, $controller, $middleware);
  }

  /**
   * PUT route handler
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */
  public function put($uri, $controller, $middleware = [])
  {
    $this->registerRoute('PUT', $uri, $controller, $middleware);
  }

  /**
   * DELETE route handler
   *
   * @param string $uri
   * @param string $controller
   * @param array $middleware
   * @return void
   */
  public function delete($uri, $controller, $middleware = [])
  {
    $this->registerRoute('DELETE', $uri, $controller, $middleware);
  }

  /**
   * Route requests
   *
   * @param string $uri
   * @param string $method
   * @return void
   */
  public function route($uri)
  {

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    // Check for methodical request
    if ($requestMethod === 'POST' && isset($_POST['_method'])) {
      // Set request method
      $requestMethod = strtoupper($_POST['_method']);
    }

    foreach ($this->routes as $route) {

      // Split request URI to segments
      $uriSegments = explode("/", trim($uri, '/'));

      // Split route URI to segments
      $routeSegments = explode("/", trim($route['uri'], "/"));

      $match = true;

      // Check number of segements
      if (
        count($uriSegments) === count($routeSegments) // 
        && strtoupper($route['method']) === $requestMethod
      ) {
        $params = [];

        $match = true;
        for ($i = 0; $i < count($uriSegments); $i++) {
          if (
            $routeSegments[$i] !== $uriSegments[$i] // URIs do not match
            && !preg_match('/\{(.+?)\}/', $routeSegments[$i]) // Regex does not match
          ) {
            $match = false;
            break;
          }

          if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) { // Match {<key>}
            $params[$matches[1]] = $uriSegments[$i]; // params[<key>] = <value>
          }
        }

        if ($match) {

          // Check for middleware
          foreach ($route['middleware'] as $role) {
            (new Authorize())->handle($role);
          }

          // Extract controller and controller method
          $controller = new ('App\\Controllers\\' . $route['controller'])();
          $controllerMethod = $route['controllerMethod'];

          // $controllerInstance = new $controller();
          $controller->$controllerMethod($params);
          return;
        }
      }




      // if ($route['uri'] === $uri && $route['method'] === $requestMethod) {
      //   // Extract controller and controller method
      //   $controller = new ('App\\Controllers\\' . $route['controller'])();
      //   $controllerMethod = $route['controllerMethod'];

      //   // init controller and call method

      //   // $controllerInstance = new $controller();
      //   $controller->$controllerMethod();
      //   return;
      // }
    }

    ErrorController::notFound();
  }
}
