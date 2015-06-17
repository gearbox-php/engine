<?

Gearbox\Engine::addGear([
	"name" => "Gearbox::Engine",
	"loader" => function($class_name){
		if(Gearbox\Engine\Loader::classicGearLoader($class_name, 'Engine', 'engine/lib/engine/')){
    	return true;
		}
		return false;
	}
]);
