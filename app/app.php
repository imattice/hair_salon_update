<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    //allows use of delete and update functions
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


//landing page which displays all stylists
    //displays landing page
    $app->get("/", function() use($app) {
        return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    });

    //creates a new stylist, saves it to the database, and displays it on the homepage
    $app->post('/stylists', function() use($app) {
        $stylist = new Stylist($_POST['stylist_name']);
        $stylist->save();
        return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    });

    //clear database of all stylists
    $app->post('/delete_stylists', function() use($app) {
        Stylist::deleteAll();
        return $app['twig']->render('home.html.twig', array('stylists'=>Stylist::getAll()));
    });


//specific stylist page
    //specific stylist landing page
    $app->get("/stylists/{id}", function($id) use($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    //deletes specific client
    $app->delete('/client/{id}', function($id) use ($app){
        $client = Client::find($id);
        $stylist = Stylist::find($_POST['stylist_id']);
        $client->delete();
        return $app['twig']->render('stylist.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    //creates new clients and displays them on the same page
    $app->post('/clients', function() use($app) {
        //takes the input values and builds a new client and saves client to database
        $client_name = $_POST['client_name'];
        $phone = $_POST['phone'];
        $stylist_id = $_POST['stylist_id'];

        $client = new Client($client_name, $phone, $stylist_id);
        $client->save();

        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylist.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    //delete all clients for a specific stylist
    $app->post('/delete_clients/{id}', function($id) use($app){
        $client = Client::find($id);
        $stylist = Stylist::find($_POST['stylist_id']);
        Client::deleteAll();
        return $app['twig']->render('stylist.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });


    //deletes one specific stylist
    $app->delete("/stylist/{id}/delete", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app['twig']->render('home.html.twig', array('stylists' => Stylist::getAll()));
    });


//client edit page
    //displays client edit page
    $app->get('/client/{id}/edit', function($id) use ($app){
        $client = Client::find($id);
        return $app['twig']->render('client_edit.html.twig', array('client'=>$client));
    });

    //posts edited data to the database to update a property in the existing restaurant
    $app->patch('/client/{id}', function($id) use ($app){
        $client = Client::find($id);
        $stylist = Stylist::find($_POST['stylist_id']);

        foreach ($_POST as $key => $value) {
            if (!empty ($value)) {
                $client->update($key, $value);
            }
        }
        return $app['twig']->render('stylist.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });


//stylist edit page
    //displays stylist edit page
    $app->get('/stylist/{id}/edit', function($id) use ($app){
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylist_edit.html.twig', array('stylist'=>$stylist));
    });

    //edits specific stylist
    $app->patch('/stylist/{id}/edit', function($id) use ($app) {
        $new_name = $_POST['name'];
        $stylist = Stylist::find($id);
        $stylist->update($new_name);

        return $app['twig']->render('stylist.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    return $app;
?>
