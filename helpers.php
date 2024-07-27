<?php

/**
 * Get base path
 * 
 * @param string $path
 * @return string
 */
function basePath($path = "")
{
  return __DIR__ . "/" . $path;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */
function loadView($name)
{
  $viewPath = basePath("views/{$name}.view.php");

  if (file_exists($viewPath)) {
    require $viewPath;
  } else {
    echo "View '{$name}' does not exists";
  }
}

/**
 * Load a partial
 *
 * @param string $name
 * @return void
 */
function loadPartial($name)
{
  $partialPath = basePath("views/partials/{$name}.partial.php");

  if (file_exists($partialPath)) {
    require $partialPath;
  } else {
    echo "Partial '{$name}' does not exists";
  }
}

/**
 * Inspect value(s)
 *
 * @param mixed $value
 * @return void
 */
function inspect($value)
{
  echo "<pre>";
  var_dump($value);
  echo "</pre>";
}

/**
 * Inspect value(s) and die
 *
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value)
{
  echo "<pre>";
  var_dump($value);
  echo "</pre>";
  die();
}
