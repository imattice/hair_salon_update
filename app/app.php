<?php

//Hey Diane!
//Just wanted to prepare you for a buggy site.  Here are some things I know are not working properly:
//-> the rest of the bugs come from the routing, which i can't say i'm super confident with right now.  I have about 70% of the routes working, with the following I know for sure do not work properly:
    //--> Client update - will route to the correct page, but the updates are not going into the database and changing the values.
    //--> Stylist delete - "No route found for GET/stylists{id}/delete".  It looks correct to me, though.
    //--> Client delete - states that I'm calling delete() on null, but there should be a client to delete. It seems that it cannot find the client_id for some reason.
//Thanks for the help!  Hope you have a good weekend!



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
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //creates a new stylist, saves it to the database, and displays it on the homepage
    $app->post('/stylists', function() use($app) {
        $stylist = new Stylist($_POST['stylist_name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //clear database of all stylists
    $app->post('/delete_stylists', function() use($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylists'=>Stylist::getAll()));
    });

//specific stylist page
    //specific stylist landing page
    $app->get("/stylists/{id}", function($id) use($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
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
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    //delete all clients for a specific stylist
    $app->post('/delete_clients/{id}', function() use($app){
        Client::deleteAll();
        $stylist = $this->getStylistId();
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    // //deletes one specific stylist
    // $app->delete("/stylists/{{stylist.getStylistId}}/delete", function($stylist_id) use ($app) {
    //     $stylist = Stylist::find($stylist_id);
    //     $stylist->delete();
    //     return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    // });
    //
    // //brings user to a page that allows a specific client to be edited
    // $app->get('/client/{client_id}/edit', function($client_id) use ($app){
    //     $client = Client::find($client_id);
    //     return $app['twig']->render('client_edit.html.twig', array('clients'=>$client));
    // });
    //
    // //posts edited data to the database to update a property in the existing restaurant
    // $app->patch('/client/{client_id}', function($client_id) use ($app){
    //     $client = Client::find($client_id);
    //     $stylist = Stylist::find($_POST['stylist_id']);
    //     //var_dump($_POST);
    //     foreach ($_POST as $key => $value) {
    //         if (!empty ($value)) {
    //             $client->update($key, $value);
    //             //var_dump($client);
    //         }
    //     }
    //     return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    // });
    //

    //
    // //deletes specific client
    // $app->delete('/client/{client_id}', function($client_id) use ($app){
    //     $client = Client::find($client_id);
    //     var_dump($client);
    //     $stylist = Stylist::find($_POST['stylist_id']);
    //     $client->delete();
    //     return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    // });


    return $app;


?>
