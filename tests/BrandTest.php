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

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_save_and_getAll() {
            $name = "Reebok";
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = "Nike";
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_rename() {
            $name = "Roooobok";
            $test_brand = new Brand($name);
            $test_brand->save();

            $new_name = "Reebok";
            $test_brand->rename($new_name);

            $result = $test_brand->getName();

            $this->assertEquals("Reebok", $result);
        }

        function test_remove() {
            $name = "Reebok";
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = "Nike";
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            $test_brand2->remove();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand], $result);
        }

        function test_find() {
            $name = "Reebok";
            $test_brand = new Brand($name);
            $test_brand->save();

            $name2 = "Nike";
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            $search_id = $test_brand2->getId();

            $result = Brand::find($search_id);

            $this->assertEquals($test_brand2, $result);
        }

    }
?>
