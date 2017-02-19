<?php
class Person
{
    private $name;

    private $money;

    private $bag = [];

    public function __construct($name, $money)
    {
        $this->setName($name);
        $this->setMoney($money);
    }


    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (empty($name)) {
            throw new Exception('Name cannot be an empty string');
        }
        $this->name = $name;
    }

    public function getMoney()
    {
        return $this->money;
    }

    public function setMoney($money)
    {
        if ($money < 0) {
            throw new Exception('Money cannot be negative');
        }
        $this->money = $money;
    }

    public function getBag()
    {
        return $this->bag;
    }

    public function setProductToBag(Product $product)
    {
        if ($product->getCost() > $this->getMoney()) {
            echo "{$this->getName()} can't afford {$product->getName()}";
        } else {
            $this->bag[] = $product->getName();
            $this->money -= $product->getCost();

            echo "{$this->getName()} bought {$product->getName()}";
        }

    }
}

class Product
{
    private $name;

    private $cost;

    public function __construct($name, $cost)
    {
        $this->setName($name);
        $this->setCost($cost);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (empty($name)) {
            throw new Exception('Name cannot be an empty string');
        }
        $this->name = $name;
    }

    public function getCost()
    {
        return $this->cost;
    }


    public function setCost($cost)
    {
        if ($cost < 0) {
            throw new Exception('Money cannot be negative');
        }
        $this->cost = $cost;
    }
}


$persons = trim(fgets(STDIN));
$products = trim(fgets(STDIN));
$personsArray = explode(';', $persons);
$productsArray = explode(';', $products);
$allPersons = [];
$allProducts = [];

foreach ($personsArray as $key => $person) {
    if (empty($person)) {
        unset($personsArray[$key]);
        break;
    }

    $personArray = explode('=', $person);
    $name = $personArray[0];
    $money = $personArray[1];

    try {
        $allPersons[$name] = new Person($name, $money);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }

}

//for ($i = 0; $i < count($personsArray); $i++) {
//    if (empty($personsArray[$i])) {
//        unset($personsArray[$i]);
//        break;
//    }
//
//    $personArray = explode('=', $personsArray[$i]);
//    $namePerson = $personArray[0];
//    $moneyPerson = $personArray[1];
//
//    $productArray = explode('=', $productsArray[$i]);
//    $nameProducts = $productArray[0];
//    $costProducts = $productArray[1];
//
//    try {
//        $allPersons[$namePerson] = new Person($namePerson, $moneyPerson);
//        $allProducts[$name] = new Product($nameProducts, $cost);
//    } catch (Exception $e) {
//        echo $e->getMessage();
//        die();
//    }
//}

foreach ($productsArray as $key => $product) {
    if (empty($product)){
        unset($productsArray[$key]);
        break;
    }

    $productArray = explode('=', $product);
    $name = $productArray[0];
    $cost = $productArray[1];

    try{
        $allProducts[$name] = new Product($name, $cost);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }

}

$commands = trim(fgets(STDIN));

while ($commands != 'END') {
    $command = explode(' ', $commands);

    /** @var Person $personName */
    $personName = $allPersons[$command[0]];

    /** @var Product $productName */
    $productName = $allProducts[$command[1]];

    $personName->setProductToBag($productName);
    echo PHP_EOL;

    $commands = trim(fgets(STDIN));
}

$result = '';
foreach ($allPersons as $key => $value) {

    $nameResult  = $allPersons[$key]->getName();
    $productsResult = empty($allPersons[$key]->getBag()) ? "Nothing bought" : implode(',', $allPersons[$key]->getBag());

    $result .= $nameResult . ' - ' . $productsResult . PHP_EOL;
}

echo trim($result);
?>
