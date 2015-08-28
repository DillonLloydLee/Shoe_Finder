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
        return $app["twig"]->render("brands.html.twig", array("brands" => $brands));
    });

    // All Stores Route
    $app->get("/stores", function() use ($app) {
        $stores = Store::getAll();
        return $app["twig"]->render("stores.html.twig", array("stores" => $stores));
    });

    return $app;
?>
