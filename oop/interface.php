<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// Interface example
interface iTemplate
{
	public function setVariable($name, $var);
	public function getHtml($template);
}

// implement the interface: iTemplate
class Template implements iTemplate
{
	private $vars = [];

	public function setVariable($name, $var)
	{
		$this->vars[$name] = $var;
	}

	public function getHtml($template)
	{
		foreach ($this->vars as $name => $value) {
			$template = str_replace('{' . $name . '}', $value, $template);
		}

		return $template;
	}
}
