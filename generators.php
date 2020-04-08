<?php
declare(strict_types = 1);

error_reporting(E_ALL);

echo '<body bgcolor="mintcream">';

// Implementing rang() as a generator
function xrange($start, $limit, $step = 1)
{
	if ($start <= $limit) {
		if ($step <=0) {
			throw new LogicException('Step must be positive');
		}

		for ($i = $start; $i <= $limit; $i += $step) {
			yield $i;
		}
	} else {
		if ($step >= 0) {
			throw new LogicException('Step must be negative');
		}

		for ($i = $start; $i >= $limit; $i += $step) {
			yield $i;
		}
	}
}

/*
 * Note that both range() and xrange() result in the same
 * output below.
 */

echo 'Single digit odd numbers from range(): ';
foreach (range(1, 9, 2) as $number) {
	echo $number . '&nbsp;';
}
echo '<br />';

echo 'Single digit odd numbers from xrange(): ';
foreach (xrange(1, 9, 2) as $number) {
	echo $number . '&nbsp;';
}
echo '<br />';

// Simple example of yielding values
function gen_one_to_three()
{
	for ($i = 1; $i <= 3; $i++) {
		// Note that $i is preserved between yields
		yield $i;
	}
}

$gen = gen_one_to_three();
foreach ($gen as $value) {
	echo $value . '&nbsp;';
}
echo '<br />';

/*
 * The input is semi-colon separated fields, with the first
 * field being an ID to use as a key.
 */
$input = <<<'EOF'
1;PHP; Likes dollar signs
2;Python; Likes whitespace
3;Ruby; Likes blocks
EOF;

function input_parser($input)
{
	foreach (explode("\n", $input) as $line) {
		$fields = explode(';', $line);
		$id = array_shift($fields);

		yield $id=>$fields;
	}
}

foreach (input_parser($input) as $id => $fields) {
	echo $id . ':<br />';
	echo "&nbsp;&nbsp;$fields[0]" . '<br />';
	echo "&nbsp;&nbsp;$fields[1]" . '<br />';
}

/*** Yielding NULLS  ***/
function gen_three_nulls()
{
	foreach (range(1, 3) as $i) {
		yield;
	}
}

var_dump(iterator_to_array(gen_three_nulls()));

/***  Yielding values by reference  ***/
function &gen_reference()
{
	$value = 3;

	while ($value > 0) {
		yield $value;
	}
}

/*
 * Note that we can change $number within the loop, and
 * because the generator is yielding references, $value
 * within gen_reference() changes.
 */
foreach (gen_reference() as &$number) {
    echo (--$number).'... ';
}

/***  yield from with iterator_to_array()  ***/
function inner() 
{
    yield 1; // key 0
    yield 2; // key 1
    yield 3; // key 2
}

function gen() 
{
    yield 0; // key 0
    yield from inner(); // keys 0-2
    yield 4; // key 1
}

// pass false as second parameter to get an array [0, 1, 2, 3, 4]
var_dump(iterator_to_array(gen()));

/*** Basic use of yield from  ***/
/*
function count_to_ten()
{
    yield 1;
    yield 2;
    yield from [3, 4];
    yield from new ArrayIterator([5, 6]);
    yield from seven_eight();
    yield 9;
    yield 10;
}

function seven_eight()
{
    yield 7;
    yield from eight();
}

function eight()
{
    yield 8;
}

foreach (count_to_ten() as $num)
{
    echo "$num ";
}
 */

// yield from and return values 
function count_to_ten()
{
    yield 1;
    yield 2;
    yield from [3, 4];
    yield from new ArrayIterator([5, 6]);
    yield from seven_eight();
    return yield from nine_ten();
}

function seven_eight()
{
    yield 7;
    yield from eight();
}

function eight()
{
    yield 8;
}

function nine_ten()
{
    yield 9;
    return 10;
}

$gen = count_to_ten();

foreach ($gen as $num) {
    echo "$num ";
}

echo $gen->getReturn();

// Comparing generators with Iterator objects
function getLinesFromFile($fileName)
{
	if (!$fileHandle = fopen($fileName, 'r')) {
		return;
	}

	while (false !== $line = fgets($fileHandle)) {
		yield $line;
	}

	fclose($fileHandle);
}

// versus...

class LineIterator implements Iterator
{
	protected $fileHandle;

	protected $line;
	protected $i;

	public function __construct($fileName)
	{
		if (!$this->fileHandle = fopen($fileName, 'r')) {
			throw new RuntimeException('Couldn\'t open file "' . $fileName . '"');
		}
	}

	public function rewind()
	{
        fseek($this->fileHandle, 0);
        $this->line = fgets($this->fileHandle);
        $this->i = 0;
    }

    public function valid()
   	{
        return false !== $this->line;
    }

    public function current()
   	{
        return $this->line;
    }

    public function key()
   	{
        return $this->i;
    }

    public function next()
   	{
        if (false !== $this->line) {
            $this->line = fgets($this->fileHandle);
            $this->i++;
        }
    }

    public function __destruct()
   	{
        fclose($this->fileHandle);
    }
}
