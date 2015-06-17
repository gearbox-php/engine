<?

namespace Gearbox\Engine;

class Loader{

  static function classicGearLoader($class_name, $gear_name, $gear_path){
    if(preg_match("/\AGearbox\\\\".$gear_name."\\\\([a-zA-Z\\\\]*)/", "$class_name", $groups)){
      $array_class_name = explode('\\', $groups[1]);
      $array_class_name = array_map(['Gearbox\ActiveSupport','underscore'], $array_class_name);
      $file = \Gearbox\Engine::gearboxDir($gear_path.implode('/',$array_class_name).'.php');
      if(file_exists($file)){
        require_once $file;
        return true;
      }
   }
   return false;
  }

  static function register($call){
    spl_autoload_register($call);
  }

  static function unregister($call){
    spl_autoload_unregister($call);
  }
}
