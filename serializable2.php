<?php

/*
* Сериализуем через интерфейс Serializable
* Таким путём можно сериализовать в одну строку длинные цепочки наследник-родитель,
 * а не делать сериализацию каждого потомка по отдельности
*/

//************* В отличие от первого варианта, здесь работаем по такой цепочке: Родитель-Наследник ********************

//********************************* Класс Book(родитель) **********************************************

class Book implements Serializable
{

    private $book;

    public function __construct() {
        $this->book = 'Book';
    }

// загружаемый метод в наследнике при сериализации наследника с родителем

    public function serialize() {
        return serialize($this->book);

    }

// загружаемый метод в наследнике при десериализации наследника с родителем

    public function unserialize($serialized) {

        $this->book = unserialize($serialized);

    }

    public function show() {

        echo $this->book . "<br>";

    }
}

//********************************* Класс Book2(наследник) **********************************************

class Book2 extends Book
{

    private $book2;
    public function __construct() {
        parent::__construct();
        $this->book2 = 'Book2';

    }

    public function serialize() {

// сериализуем родителя Book с приватными свойствами

        $serialized = parent::serialize();

// сериализуем наследника Book2 и родителя Book

        return serialize([$this->book2, $serialized]);

    }

    public function unserialize( $serialized ) {

// десериализуем  наследника Book2 и родителя Book

        $temp = unserialize($serialized);
        $this->book2= $temp[0];

// десериализуем родителя Book с приватными свойствами

        parent::unserialize($temp[1]);

    }
}

$obj = new Book2();
$serialized = serialize($obj);			// сериализация цепочки наследник-родитель
echo $serialized . "<br>";
$restored = unserialize($serialized);	// десериализация цепочки наследник-родитель
$restored->showVar();

?>