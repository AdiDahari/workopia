<?php

/**
 * Get base path
 * 
 * @param string $path
 * @return string
 */
function basePath($path = '')
{
  return __DIR__ . '/' . $path;
}

/**
 * Load a partial view
 *
 * @param string $name
 * @return void
 */
function loadPartial($name)
{
  $partialPath = basePath("views/partials/{$name}.php");

  if (!file_exists($partialPath)) {
    throw new Exception("Partial `{$name}` not found");
  }
  require $partialPath;
}

/**
 * Load a view
 *
 * @param string $name
 * @return void
 */
function loadView($name, $data = [])
{
  $viewPath = basePath("views/{$name}.view.php");

  if (!file_exists($viewPath)) {
    throw new Exception("View `{$name}` not found");
  }
  extract($data, EXTR_SKIP);
  require $viewPath;
}

/**
 * Inspect value(s)
 *
 * @param mixed $value
 * @return void
 */
function inspect($value)
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
}

/**
 * Inspect value(s) and die 
 *
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value)
{
  echo '<pre>';
  var_dump($value);
  echo '</pre>';
  die();
}

/**
 * Format a salary
 * 
 * @param string $salary
 * 
 * @return string
 */
function formatSalary($salary)
{
  return '$' . number_format(floatval($salary), 0, '.', ',');
}
