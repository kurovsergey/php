<?php
use \DrewM\MailChimp\MailChimp;

class Application{

    private $db = null;
    private $view = null;
    private $config = [];

    public function __construct($db, $view, $config){
        $this->db = $db;
        $this->view = $view;
        $this->config = $config;
    }

    public function setAction($action = 'main', $params = []){
        switch ($action){
            case 'main':
                $this->view->setContent('main', $params);
            break;
            case 'sendUserData':
                $this->sendUserData();
            break;
            case 'confirmEmail':
                $this->view->setContent('confirmEmail', $params);
                $this->confirmUser((int)$params['user_id']);
            break;
        }
        return $this;
    }

    private function sendUserData(){
        header("Content-type: application/json; charset=utf-8");
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            if($userId = $this->createUser($_REQUEST['email'], $_REQUEST['name'])) {
                if($this->sendConfirmMail($_REQUEST['email'], $_REQUEST['name'],$userId)) {
                    header("HTTP/1.0 200 Ok");
                    die(json_encode([
                        'result' => 'ok'
                    ]));
                }
            }
        }

        header("HTTP/1.0 400 Bad Request");
    }

    private function createUser($email, $name){
        if(filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[a-z]+$/i', $name)){
            if($this->db->execute('INSERT INTO users(name,email) VALUES (\''.$name.'\',\''.$email.'\')')){
                return $this->db->getLastId();
            }
        }
        return false;
    }

    private function sendConfirmMail($email, $name, $user_id){
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: ". $email . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf8\r\n";

        $subject = $name.' please confirm email';
        $message = 'Please confirm your email 
                    <a href="//'.$_SERVER['SERVER_NAME'].'/index.php?action=confirmEmail&user_id='.$user_id.'">Confirm link</a>';
        return mail($email, $subject, $message, $headers);
    }

    private function confirmUser($user_id){
        if($this->db->execute('INSERT INTO mails(user_id) VALUES('.$user_id.')')){
            $this->db->execute('UPDATE users SET is_active=1 WHERE id='.$user_id);
            //--Add user to mailchimp lists
            if($user = $this->db->fetch('SELECT email FROM users WHERE id='.$user_id)){
                $mailChimpId = $this->postUserToMailchimp($user[0]['email']);
                $this->db->execute('UPDATE mails SET mailchimp_id=\''.$mailChimpId.'\' WHERE user_id='.$user_id);
            }
            return $this->db->getLastId();
        }
        return false;
    }

    private function postUserToMailchimp($email){
        $mailChimp = new MailChimp($this->config['mailchimp']['apiKey']);
        $result = $mailChimp->post("lists/".$this->config['mailchimp']['listId']."/members", [
            'email_address' => $email,
            'status'        => 'subscribed',
        ]);

        if ($mailChimp->success()) {
            return $result['id'];
        } else {
            die($mailChimp->getLastError());
        }

    }

}