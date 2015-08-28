<?php
    class Store {
        private $name;
        private $id;

        function __construct($name, $id = null) {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($name) {
            $this->name = (string) $name;
        }

        function getName() {
            return $this->name;
        }

        function getId() {
            return $this->id;
        }

        function save() {
            $GLOBALS["DB"]->exec("INSERT INTO stores (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS["DB"]->lastInsertId();
        }

        static function getAll() {
            $raw_all = $GLOBALS["DB"]->query("SELECT * FROM stores;");
            $all = array();
            foreach($raw_all as $store) {
                $name = $store["name"];
                $id = $store["id"];
                $new_store = new Store($name, $id);
                array_push($all, $new_store);
            }
            return $all;
        }

        static function deleteAll() {
            $GLOBALS["DB"]->exec("DELETE FROM stores;");
        }

        static function find($search_id) {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        function rename($new_name) {
            $GLOBALS["DB"]->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function remove() {
            $GLOBALS["DB"]->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE stores_id = {$this->getId()};");
        }

        function addBrand($brand) {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brands_id, stores_id) VALUES ({$brand->getId()}, {$this->getId()});");
        }

        function getBrands() {
            $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM
                stores JOIN brands_stores ON (stores.id = brands_stores.stores_id)
                         JOIN brands ON (brands_stores.brands_id = brands.id)
                         WHERE stores.id = {$this->getId()};");

            $brands = array();
            foreach($returned_brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }


    }
?>
