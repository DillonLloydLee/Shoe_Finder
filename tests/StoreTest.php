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
            $name = "Dirty Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Clean Shoes";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_rename() {
            $name = "POOOOP Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $new_name = "Poop Shoes";
            $test_store->rename($new_name);

            $result = $test_store->getName();

            $this->assertEquals("Poop Shoes", $result);
        }

        function test_remove() {
            $name = "Dirty Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Clean Shoes";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $test_store2->remove();

            $result = Store::getAll();

            $this->assertEquals([$test_store], $result);
        }

        function test_find() {
            $name = "Dirty Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name2 = "Clean Shoes";
            $test_store2 = new Store($name2);
            $test_store2->save();

            $search_id = $test_store2->getId();

            $result = Store::find($search_id);

            $this->assertEquals($test_store2, $result);
        }

        function test_addBrand_and_getBrands() {
            $name = "Dirty Shoes";
            $test_store = new Store($name);
            $test_store->save();

            $name = "Reebok";
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = "Nike";
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);

            $result = $test_store->getBrands();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }







    }
?>
