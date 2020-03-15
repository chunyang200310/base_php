<?php
error_reporting(7);

echo '<body bgcolor="mintcream"><pre>';

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

for ($i = 1, $j = 0; $i <=10; $j += $i, print $i, $i++);
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
