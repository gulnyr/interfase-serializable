<?php
/*
interface Serializable
{
	abstract public string serialize ( void )				- Возращает строковое представление объекта.
	abstract public void unserialize ( string $serialized )	- Десеарилизует строковое представление объекта $serialized
}
Serializable - интерфейс для индивидуальной сериализации.

В отдичие от __sleep() и __wakeup() позволяет более гибко управлять сериализацией, напр. при работе с наследуемыми классами (см. Serializable_example.php)
*/



// ************************Создадим интерфейс Serializable******************************


class MyClass implements Serializable {

    // Создаем приватное свойство для дальнейшего использования

    private $data;

    // Создаем конструктор

    public function __construct() {

        // Добавим строку в наше свойство (для примера)

        $this->data = 'Мои личные данные';
    }

    // автоматически вызывается при попытке сериализации объекта этого класса

    public function serialize() {
        // Магия __CLASS__ подставляет имя класса, в нашем случае MyClass
        echo 'Объект класса '. __CLASS__ .' сериализован<br>';

        // возвращается результат сериализации

        return serialize($this->data);
    }

    // автоматически вызывается при десериализации объекта этого класса

    public function unserialize($data) {
        echo 'Объект класса '. __CLASS__ .' десериализован<br>';

        // выполняем десериализацию

        $this->data = unserialize($data);
    }

    // Просто возвращаем то, что в привате
    // Обязательно после десериализации

    public function getData() {
        return $this->data;
    }

}

// Создаем экземпляр

$obj = new MyClass;

//сериализуем объект - вызов метода $obj->serialize()

$ser = serialize($obj);

//десериализуем объект - вызов метода $obj->unserialize()

$newobj = unserialize($ser);

var_dump($newobj->getData());

?>