<?php

class Book
{
    private $title;

    private $author;

    private $price;

    private $information;

    public function __construct($title, $author, $price)
    {
        $this->setTitle($title);
        $this->setAuthor($author);
        $this->setPrice($price);
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        if (strlen($title) < 3) {
            throw new Exception("Title not valid!");
        }
        $this->title = $title;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $authorArray = explode(" ", $author);
        $secondName = $authorArray[1];
        if (is_numeric($secondName[0])) {
            throw new Exception("Author not valid!");
        }

        $this->author = $author;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        if ($price <= 0) {
            throw new Exception("Price not valid!");
        }
        $this->price = $price;
    }

    public function getInformation()
    {
        echo "OK" . PHP_EOL;
        echo $this->getPrice();
    }
}

class GoldenEditionBook extends Book
{
    public function setPrice($price)
    {
        $price = $price * 1.3;
        parent::setPrice($price);
    }
}

$author = trim(fgets(STDIN));
$title = trim(fgets(STDIN));
$price = trim(fgets(STDIN));
$type = trim(fgets(STDIN));

$book = '';
try {
    switch ($type) {
        case "STANDARD" : {
            $book = new Book($title, $author, $price);
            break;
        }
        case "GOLD" : {
            $book = new GoldenEditionBook($title, $author, $price);
            break;
        }
        default : {
            throw new Exception("Type is not valid!");
        }
    }

    $book->getInformation();

} catch (Exception $e) {
    echo $e->getMessage();
}
