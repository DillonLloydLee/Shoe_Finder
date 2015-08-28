<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();
    $app["debug"] = true;

    $server = "mysql:host=localhost;dbname=shoes";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        "twig.path" => __DIR__."/../views"));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // Home Route: Choose Brand or Store.
    $app->get("/", function() use($app) {
        return $app["twig"]->render("index.html.twig");
    });

    // All Brands Route
    $app->get("/brands", function() use ($app) {
        $brands = Brand::getAll();
        return $app["twig"]->render("brands.html.twig", array("brands" => $brands, "new" => 0));
    });

    // All Stores Route
    $app->get("/stores", function() use ($app) {
        $stores = Store::getAll();
        return $app["twig"]->render("stores.html.twig", array("stores" => $stores, "new" => 0));
    });

    // All Brands Route: Brand Added
    $app->post("/brand_added", function() use ($app) {
        $new_brand = new Brand($_POST["name"]);
        $new_brand->save();
        $brands = Brand::getAll();
        return $app["twig"]->render("brands.html.twig", array("brands" => $brands, "new" => 1));
    });

    // All Stores Route: Store Added
    $app->post("/store_added", function() use ($app) {
        $new_store = new Store($_POST["name"]);
        $new_store->save();
        $stores = Store::getAll();
        return $app["twig"]->render("stores.html.twig", array("stores" => $stores, "new" => 1));
    });

    // Individual Store Route
    $app->get("/store-{id}", function($id) use ($app){
        $store = Store::find($id);
        return $app['twig']->render("store_info.html.twig", array('store' => $store, "new" => 0));
    });

    // Individual Brand Route
    $app->get("/brand-{id}", function($id) use ($app){
        $brand = Brand::find($id);
        return $app['twig']->render("brand_info.html.twig", array('brand' => $brand, "new" => 0));
    });

    return $app;
?>
