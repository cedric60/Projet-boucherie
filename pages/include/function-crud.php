<?php

    $message = false;

    $bdd = connectToDataBAse();

    require_once "config.php";
    // $toto = emailExiste("ku@luyf.ouh");
    // var_dump($toto);

    function connectToDataBase(){
        try{
            $bdd = new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME, DATABASE_USER, DATABASE_PASS); // Création d'une instance de connection à la base de donnée
            return $bdd;
        }catch (PDOException $e) {
            $GLOBALS["message"] = "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function emailExiste($email){


        $sql = "SELECT count(*) as Nb FROM `clients` WHERE email = ?"; // initianilisation de la requete (renvoi le nb de clients dont l'email = $email)

        $request = $GLOBALS["bdd"]->prepare($sql); // prepare la requete avant execution

        $request->execute(Array($email)); // execute la requete en remplacant les ? par les datas du tableau

        $array =  $request->fetchAll(PDO::FETCH_ASSOC);
        
        return (bool)$array[0]["Nb"];
    }

    function registerClient($client){

        $sql ="INSERT INTO `clients`(`firstname`, `lastname`, `email`, `encrypte`, `phone`) VALUES (:firstname,:lastname,:email,:encrypte,:phone)";

        $request = $GLOBALS["bdd"]->prepare($sql); // prepare la requete avant execution
        
        $array = Array(":lastname" => $client["lastname"],":firstname" => $client["Firstname"],":email" => $client["email"],":phone" => $client["phonenumber"],":encrypte" => cryptPassword($client["password"]));

        $request->execute($array); // execute la requete en remplacant les ? par les datas du tableau

        return $GLOBALS["bdd"]->lastInsertId();
    }

    function cryptPassword($password){
        $crypt = sha1(rand(11, 22)."Mike".uniqid()."Mike".rand(11, 22));
        return crypt($password, $crypt);    
    }

    function comparePassword($hashed_password, $salt){
       return (hash_equals($hashed_password, crypt($password, $hashed_password)))?true:false;     
    }

?>