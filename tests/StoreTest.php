<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Brand.php';
    require_once 'src/Store.php';

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_save_and_getAll() {
            $name = "Filthy's Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Dirty's Budget Boots";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store, $test_store2], $result);
        }

    }
?>
