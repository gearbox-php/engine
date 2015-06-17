<?

Gearbox\Engine::addGear([
	"loader" => function($class_name){
	   if(preg_match("/\AGearbox\\\Engine\\\([a-zA-Z\\\]*)/", "$class_name", $groups)){
       $array_class_name = explode('\\', $groups[1]);
       $array_class_name = array_map(['Gearbox\ActiveSupport','underscore'], $array_class_name);
       $file = Gearbox\Engine::gearboxDir("engine/lib/engine/".implode('/',$array_class_name).'.php');
       if(file_exists($file)){
         require_once $file;
         return true;
       }
		}
		return false;
	}
]);
