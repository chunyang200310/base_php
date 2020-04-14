<?php
/* Factory.class.php
 * 工厂类,根据传入的模型类的名字, 实例化模型对象并返回
 */
declare(strict_types = 1);

namespace framework\core;

error_reporting(E_ALL);

class Factory
{
	public static function M($modelName)
	{
		static $model_list = [];

		if (substr($modelName, -5) != 'Model') {
			$modelName .= 'Model';
		}

		if (!strchr($modelName, '\\')) {
			$modelName = MODULE . '\model\\' . $modelName;
		}

		if (!isset($model_list[$modelName])) {
			$model_list[$modelName] = new $modelName;
		}
		return $model_list[$modelName];
	}
}
