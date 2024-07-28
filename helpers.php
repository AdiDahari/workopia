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
function loadView($name, $data = [])
{
  $viewPath = basePath("App/views/{$name}.view.php");

  if (file_exists($viewPath)) {
    extract($data);
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
  $partialPath = basePath("App/views/partials/{$name}.partial.php");

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

/**
 * Format salary string
 *
 * @param string $salary
 * @return string
 */
function formatSalary($salary)
{
  return '$' . number_format(floatval($salary));
}
