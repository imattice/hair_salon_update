<?php
    class Client
    {
        private $client_name;
        private $phone;
        private $stylist_id;
        private $client_id;

        function __construct ($client_name, $phone, $stylist_id, $client_id = null)
        {
            $this->client_name = $client_name;
            $this->phone = $phone;
            $this->stylist_id = $stylist_id;
            $this->client_id = $client_id;
        }

    //sets properties to assigned input types
        function setClientName($new_client_name)
        {
            $this->client_name = (string) $new_client_name;
        }

        function setPhone($new_phone)
        {
            $this->phone = (string) $new_phone;
        }

        function getClientName()
        {
            return $this->client_name;
        }

        function getPhone()
        {
            return $this->phone;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        function getClientId()
        {
            return $this->client_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO t_clients (name, phone, stylist_id) VALUES ('{$this->getClientName()}', '{$this->getPhone()}', {$this->getStylistId()});");
            $this->client_id = $GLOBALS['DB']->lastInsertId();
        }

        function update($column_to_update, $new_information)
        {
            $GLOBALS['DB']->exec("UPDATE t_clients SET {$column_to_update} = '{$new_information}' WHERE id = {$this->getClientId()};");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM t_clients WHERE id = {$this->getClientId()};");
        }


        static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();
            foreach ($clients as $client){
                $client_id = $client->getClientId();
                if ($client_id == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }


        static function getAll()
        {
            $db_clients = $GLOBALS['DB']->query("SELECT * FROM t_clients;");
            //var_dump($db_clients);
            $clients = array();
            foreach($db_clients as $client) {
                    $client_name = $client['name'];
                    $phone = $client['phone'];
                    $stylist_id = $client['stylist_id'];
                    $client_id = $client['id'];
                    $new_client = new Client($client_name, $phone, $stylist_id, $client_id);
                    //var_dump($new_client);
                    array_push($clients, $new_client);
            }
            //var_dump($clients);
            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM t_clients;");
        }

    }
 ?>
