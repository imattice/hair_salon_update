<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Client.php";
    require_once "src/Stylist.php";

    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }
        function test_getClientName()
        {

        //Arrange
        $client_name = "Ike";
        $phone = "1234567890";
        $stylist_id = 1;
        $client_id = null;
        $test_client = new Client($client_name, $phone, $stylist_id, $client_id);

        //Act
        $result = $test_client->getClientName();

        //Assert
        $this->assertEquals($client_name, $result);
        }

        function test_getPhone()
        {

        //Arrange
        $client_name = "Ike";
        $phone = "1234567890";
        $stylist_id = 1;
        $client_id = null;
        $test_client = new Client($client_name, $phone, $stylist_id, $client_id);

        //Act
        $result = $test_client->getPhone();

        //Assert
        $this->assertEquals($phone, $result);
        }

        function getStylistId()
        {
            //Arrange
            $stylist_name = "Sue";
            $stylist_id = null;
            $test_stylist = new Stylist($stylist_name, $stylist_id);
            $test_stylist->save();

            $client_name = "Ike";
            $phone = "1234567890";
            $stylist_id = 1;
            $client_id = null;
            $test_client = new Client($client_name, $phone, $stylist_id, $client_id);

            //Act
            $result = $test_client->getStylistId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getClientId()
        {

            //Arrange
            $client_name = "Ike";
            $phone = "1234567890";
            $stylist_id = 1;
            $client_id = null;
            $test_client = new Client($client_name, $phone, $stylist_id, $client_id);

            //Act
            $result = $test_client->getClientId();

            //Assert
            $this->assertEquals($client_id, $result);
        }

        function test_save()
        {
            //Arrange
            $stylist_name = "Sue";
            $stylist_id = null;
            $test_stylist = new Stylist($stylist_name, $stylist_id);
            $test_stylist->save();

            $client_name = "Ike";
            $phone = "1234567890";
            $stylist_id = 1;
            $client_id = null;
            $test_client = new Client($client_name, $phone, $stylist_id, $client_id);

            //Act
            $test_client->save();

            //Assert
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $stylist_name = "Sue";
            $stylist_id = null;
            $test_stylist = new Stylist($stylist_name, $stylist_id);
            $test_stylist->save();

            $client_name = "Ike";
            $phone = "1234567890";
            $client_id = null;
            $stylist_id = $test_stylist->getStylistId();
            $test_client = new Client($client_name, $phone, $stylist_id, $client_id);
            $test_client->save();
            //var_dump($test_client);

            $client_name2 = "Katri";
            $phone2 = "0987654321";
            $test_client2 = new Client($client_name2, $phone2, $stylist_id, $client_id);
            $test_client2->save();
            //var_dump($test_client2);

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $stylist_name = "Sue";
            $stylist_id = null;
            $test_stylist = new Stylist($stylist_name, $stylist_id);
            $test_stylist->save();

            $client_name = "Ike";
            $phone = "1234567890";
            $stylist_id = $test_stylist->getStylistId();
            $client_id = null;
            $test_client = new Client($client_name, $phone, $stylist_id, $client_id);
            $test_client->save();

            $client_name2 = "Katri";
            $phone2 = "0987654321";
            $test_client2 = new Client($client_name2, $phone2, $stylist_id, $client_id);
            $test_client2->save();

            //Act
            Client::deleteAll();

            //Assert
            $result = Client::getAll();
            $this->assertEquals([], $result);
        }

        function test_update()
        {
            //Arrange
            $stylist_name = "Sue";
            $stylist_id = null;
            $test_stylist = new Stylist($stylist_name, $stylist_id);
            $test_stylist->save();

            $client_name = "Ike";
            $phone = "1234567890";
            $stylist_id = $test_stylist->getStylistId();
            $client_id = null;
            $test_client = new Client($client_name, $phone, $stylist_id, $client_id);
            $test_client->save();

            $column_to_update = "name";
            $new_information = "Michael";

            //Act
            $test_client->update($column_to_update, $new_information);

            //Assert
            $result = Client::getAll();
            $this->assertEquals("Michael", $result[0]->getClientName());
        }

        function test_delete()
        {
            //Arrange
            $stylist_name = "Sue";
            $stylist_id = null;
            $test_stylist = new Stylist($stylist_name, $stylist_id);
            $test_stylist->save();

            $client_name = "Ike";
            $phone = "1234567890";
            $client_id = null;
            $stylist_id = $test_stylist->getStylistId();
            $test_client = new Client($client_name, $phone, $stylist_id, $client_id);
            $test_client->save();

            $client_name2 = "Katri";
            $phone2 = "0987654321";
            $test_client2 = new Client($client_name2, $phone2, $stylist_id, $client_id);
            $test_client2->save();

            //Act
            $test_client->delete();

            //Assert
            $this->assertEquals([$test_client2], Client::getAll());
        }

        function test_find()
        {
            //Arrange
            $stylist_name = "Sue";
            $stylist_id = null;
            $test_stylist = new Stylist($stylist_name, $stylist_id);
            $test_stylist->save();

            $client_name = "Ike";
            $phone = "1234567890";
            $client_id = null;
            $stylist_id = $test_stylist->getStylistId();
            $test_client = new Client($client_name, $phone, $stylist_id, $client_id);
            $test_client->save();

            $client_name2 = "Katri";
            $phone2 = "0987654321";
            $test_client2 = new Client($client_name2, $phone2, $stylist_id, $client_id);
            $test_client2->save();

            //Act
            $result = Client::find($test_client->getClientId());

            //Assert
            $this->assertEquals($test_client, $result);
        }

    }






    ?>
