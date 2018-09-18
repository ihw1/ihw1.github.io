<?php
/**
 * EpiCode master file
 *
 * This contains the EpiCode class as wel as the EpiException abstract class
 * @author  Jaisen Mathai <jaisen@jmathai.com>
 * @version 1.0
 * @package EpiCode
 */
class Epi
{
  private static $properties = array('exceptions-setting' => false, 'debug-setting' => false);
  private static $manifest = array(
    '*' => array('base','route','template'),
    'api' => array('EpiApi.php', 'route'),
    'base' => array('EpiException.php'),
    'route'  => array('base', 'EpiRoute.php'),
  );
  private static $included = array();
  public static function init()
  {
    //  Setup the base directory first.
    if(!self::isPathSet('base')) {
      self::setPath('base', realpath(dirname(__FILE__)));
    }
    $args = func_get_args();
    if(!empty($args))
    {
      foreach($args as $arg)
        self::loadDependency($arg);
    }
  }
  public static function isPathSet($name) {
    return isset(self::$properties["{$name}-path"]);
  }
  public static function setPath($name, $path)
  {
    self::$properties["{$name}-path"] = $path;
  }
  public static function getPath($name)
  {
    return isset(self::$properties["{$name}-path"]) ? self::$properties["{$name}-path"] : null;
  }
  public static function setSetting($name, $value)
  {
    self::$properties["{$name}-setting"] = $value;
  }
  public static function getSetting($name)
  {
    return isset(self::$properties["{$name}-setting"]) ? self::$properties["{$name}-setting"] : false;
  }
  private static function loadDependency($dep)
  {
    $value = isset(self::$manifest[$dep]) ? self::$manifest[$dep] : $dep;
    if(!is_array($value))
    {
      if(!isset(self::$included[$value]))
        include(self::getPath('base') . "/{$value}");
      self::$included[$value] = 1;
    }
    else
    {
      foreach($value as $d)
        self::loadDependency($d);
    }
  }
}
