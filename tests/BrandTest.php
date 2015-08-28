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

    }
?>
