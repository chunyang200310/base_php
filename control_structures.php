<?php
error_reporting(E_ALL);

echo '<body bgcolor="mintcream"><pre>';

// if / elseif / else
$a = mt_rand(0, 5);
$b = mt_rand(0, 5);

if ($a > $b) {
	echo 'a is bigger than b';
} elseif ($a == $b) {
	echo 'a is equal to b';
} else {
	echo 'a is smaller than b';
}

// alternative syntax for control structures
if ($a == 5):
	echo 'a equals 5';
	echo '...';
elseif ($a == 6):
	echo 'a equals 6';
else:
	echo 'a is neither 5 nor 6';
endif;

// while
$i = 1;
while ($i <=10) {
	echo $i++;
}

while ($i <= 10):
	echo $i;
	$i++;
endwhile;

// do-while
do {
    if ($i < 5) {
        echo "i is not big enough";
        break;
    }
    $i *= $factor;
    if ($i < $minimum_limit) {
        break;
    }
   echo "i is ok";
    /* process i */
} while (0);

// for
for ($i = 1, $j = 0; $i <=10; $j += $i, print $i, $i++);
for ($i = 1; $i <= 10; $i++) {
    echo $i;
}
for ($i = 1; ; $i++) {
    if ($i > 10) {
        break;
    }
    echo $i;
}
$i = 1;
for (; ; ) {
    if ($i > 10) {
        break;
    }
    echo $i;
    $i++;
}

// foreach
$arr = array(1, 2, 3, 4);
foreach ($arr as &$value) {
    $value = $value * 2;
}
// $arr is now array(2, 4, 6, 8)
unset($value); // break the reference with the last element
foreach (array(1, 2, 3, 4, 5) as $v) {
    echo "$v\n";
}

$arr = [1, 2, 3, 4];
while (list($key, $value) = each($arr)) {
    	echo "key: $key; value: $value<br />";
}

$arr = [
        [1, 2],
        [3, 4]
    ];
	
foreach ($arr as list($a, $b)) {
    echo "A: $a; B:$b<br />";
}

foreach ($arr as list($a)) {
    // Note that there is no $b here.
    echo "$a\n";
}

// A notice will be generated if there aren't enough array elements to fill the list(): 
foreach ($arr as list($a, $b, $c)) {
    echo "A: $a; B: $b; C: $c<br />";
}

echo '<br />';

// break
$arr = ['one', 'two', 'three', 'four', 'stop', 'five'];
while (list(, $val) = each($arr)) {
    if ($val == 'stop') {
	break;
    }
    echo "$val<br />";
}

// continue
for ($i = 0; $i < 5; ++$i) {
    if ($i == 2)
        continue;
    print "$i\n";
}

// switch
$i = mt_rand(1, 2);
echo $i . '<br />';
switch ($i) {
    case 0:
        echo "i equals 0";
        break;
    case 1:
        echo "i equals 1";
        break;
    case 2:
        echo "i equals 2";
        break;
}

// goto
goto a;
echo 'Foo';
 
a:
echo 'Bar';

for($i=0,$j=50; $i<100; $i++) {
  while($j--) {
    if($j==17) goto end;
  }
}
echo "i = $i";
end:
echo 'j hit 17';
