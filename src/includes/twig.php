<?php


$twig->addFunction(new Twig\TwigFunction('getUrl', function (string $name, array $params = []) 
{     
	global $router;     
	return $router->generate($name, $params); 
}));






// namespace App;

// use Twig\TwigFunction;

// class Twig {

// 	public $twig;

// 	public function __construct ($twig)
// 	{
// 		$this->twig = $twig;
// 		$this->addFn();
// 	}

// 	/**
// 	 * Add function to twig
// 	 */
// 	private function addFn (): void
// 	{
// 		$this->twig->addFunction(new TwigFunction('getUrl',[$this, 'getUrl']));
// 	}

// 	/**
// 	 * Use router url generate
// 	 */
// 	public function getUrl (string $name, array $params = []): string
// 	{
// 		global $router;
// 		return $router->generate($name, $params);
// 	}
// }

// new Twig($twig);