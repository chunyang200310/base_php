<?php
error_reporting(E_ALL);

echo '<body bgcolor="mintcream"> <pre>';

// create constans with: define(key, value);
define('PI', 3.14);
define('NAME', 'lisi');
define('TRUTH', true);
define('HERO', ['name'=>'xiangyu', 'age'=>18, 'sex'=>'male']);
var_dump(PI, NAME, TRUTH, HERO);

// create constans with: const key = value;
const PI2 = 3.14;
const NAME2 = 'zhangsan';
const LIES = false;
const MEINV = ['diaochan', 'xishi', 'zhaojun', 'guifei'];
var_dump(PI2, NAME2, LIES, MEINV);

// use constants in function directly
function getValue()
{
	echo PI * 2;
	echo NAME;
	echo MEINV[0];
	return PI * 2;
}

getValue();
