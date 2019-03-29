<?php

namespace Controller\API;

class Controller {

    public function __construct() {

        $router = \Core\Router::getInstance();
        $router->add('GET', '/api/messages', function() {
            $firstname = preg_replace("/[^a-z0-9]/i", "", $_GET['firstname']);
            $lastname = preg_replace("/[^a-z0-9]/i", "", $_GET['lastname']);
            $surname = preg_replace("/[^a-z0-9]/i", "", $_GET['surname']); 
            $subject = preg_replace("/[^a-z0-9]/i", "", $_GET['subject']); 
            $message = preg_replace("/[^a-z0-9]/i", "", $_GET['message']);
            $mail = preg_replace('/(?<=@.)[a-zA-Z0-9-]*(?=(?:[.]|$))/', '*',$_GET['mail']);  

           $pdo = \Core\Db::getInstance()->getPDO();
            $stmt = $pdo->query("SELECT * FROM mess ORDER BY data DESC LIMIT 50");
            $data = $stmt->fetchAll();
            header("Content-type: application/json");
            $json = json_encode($data);
            die($json);
        });

        $router->add('POST','/api/messages', function() {
            $firstname = $_POST['firstname'];
            $surname = $_POST['surname'];
            $mail = $_POST['mail'];
            $message = $_POST['message'];
            if (empty($_POST["firstname"])) {
                $firstNameErr = "First name is required";
            }
            else {
                $firstname = test_input($_POST["firstname"]);
            }
            if (empty($_POST["surname"])) {
                $surnameErr = "Surname is required";
            }
            else {
                $surname = test_input($_POST["surname"]);
            }
            if(empty($_POST['mail'])) {
                $mailErr = "Mail is required";
            }
            else {
                $mail = test_input($_POST["mail"]);
            }
            if (empty($_POST['message'])) {
                $messageErr = "Message is required";
            }
            else {
                $message = test_input($_POST['message']);
            
            }
            $body=(Object)json_decode(file_get_contents('php://input'));
            $pdo =\Core\Db::getInstance()->getPDO();
            $sql = "INSERT INTO mess (firstname,lastname,surname,message,mail,subject) VALUES (:firstname,:lastname,:surname,:message,:mail,:subject)"; 
            $stmt =$pdo->prepare($sql);
            $stmt->execute([
                'firstname' => $body->firstname,
                'lastname' => $body->lastname,
                'surname' => $body->surname,
                'message' => $body->message,
                'mail' => $body->mail,
                'subject' => $body->subject,
            ]);

            http_response_code(201);
            die();
        });
          }
 
}
