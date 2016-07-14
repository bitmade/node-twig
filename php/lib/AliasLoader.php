<?php

/**
 * Class AliasLoader
 *
 * Loads classes by alias names like @views or @theme.
 */
class AliasLoader extends Twig_Loader_Filesystem {

  /**
   * AliasLoader constructor.
   *
   * @param $paths
   *    An array of paths to pass to the parent constructor.
   * @param $aliases
   *    An array of alias/path pairs.
   */
  public function __construct($paths, $aliases) {
    parent::__construct($paths);

    foreach ($aliases as $alias => $path) {
      $this->addPath($path, $alias);
    }
  }

  /**
   * Adds a path where templates are stored.
   *
   * @param string $path
   *   A path where to look for templates.
   * @param string $namespace
   *   (optional) A path name.
   */
  public function addPath($path, $namespace = self::MAIN_NAMESPACE) {
    // Invalidate the cache.
    $this->cache = array();
    $this->paths[$namespace][] = rtrim($path, '/\\');
  }
}
