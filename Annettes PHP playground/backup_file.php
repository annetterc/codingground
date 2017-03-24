<html>
<head>
<title>Online PHP Script Execution</title>
</head>
<body>
<?php
   echo "<h1>Hello, PHP!</h1>";
   
class Test {
    function foo(){ echo "FOO"; }
    function baz(){ return "BAZ"; }
    function bar(){ echo "BAR"; }
}

  class Chainable {
    private $instance = null;
    public function __construct(){
        $pars = func_get_args();
        $this->instance = is_object($obj=array_shift($pars))?$obj:new $obj($pars);
    }

    public function __call($name,$pars){
        call_user_func_array([$this->instance,$name],$pars);
        return $this;
    }

}

  $test = new Chainable('Test');
  $test->foo()->baz()->bar();
  
  class MyIterator implements Iterator
{
    private $var = array();

    public function __construct($array)
    {
        if (is_array($array)) {
            $this->var = $array;
        }
    }

    public function rewind()
    {
        echo "rewinding\n";
        reset($this->var);
    }
  
    public function current()
    {
        $var = current($this->var);
        echo "current: $var\n";
        return $var;
    }
  
    public function key() 
    {
        $var = key($this->var);
        echo "key: $var\n";
        return $var;
    }
  
    public function next() 
    {
        $var = next($this->var);
        echo "next: $var\n";
        return $var;
    }
  
    public function valid()
    {
        $key = key($this->var);
        $var = ($key !== NULL && $key !== FALSE);
        echo "valid: $var\n";
        return $var;
    }

}
  
  class MyCollection implements IteratorAggregate
{
    private $items = array();
    private $count = 0;

    // Required definition of interface IteratorAggregate
    public function getIterator() {
        return new MyIterator($this->items);
    }

    public function add($value) {
        $this->items[$this->count++] = $value;
    }
}

$coll = new MyCollection();
$coll->add('value 1');
$coll->add('value 2');
$coll->add('value 3');

foreach ($coll as $key => $val) {
    echo "key/value: [$key -> $val]\n\n";
}
  
?>
</body>
</html>
