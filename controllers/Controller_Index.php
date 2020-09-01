<?php
    Class Controller_Index Extends Controller_Base{
        function index(){

            $typeSort = isset($_GET['typeSort']) ? $_GET['typeSort'] : false;
            $sortDirection = isset($_GET['sortDirection']) ? $_GET['sortDirection'] : false;
            $sort = '';

            if ($typeSort && $sortDirection) {
                $sort = ' ORDER BY ';
                switch ($typeSort) {
                    case 'name':
                        $sort .= 'username';
                        break;
                    case 'email':
                        $sort .= 'email';
                        break;
                    case 'status':
                        $sort .= 'status';
                }
                $sort .= ' ' . $sortDirection;
            }

            $userDb = $this->registry['db']->query("SELECT 
                users.username,
                users.email,
                questionnaire.text,
                questionnaire.status,
                questionnaire.id,
                questionnaire.edited,
                questionnaire.updated
                FROM users, questionnaire
                WHERE questionnaire.user_id = users.id" . $sort)->fetchAll();

            $countPages = ceil(count($userDb) / 3);
            if (isset($_GET['p']) && $_GET['p'] != 1) {
                $start = $_GET['p'] * 3 - 3; 
                $userDb = array_slice($userDb, $start, 3);
            } else {
                $userDb = array_slice($userDb, 0, 3);
            }

            $this->registry['template']->set('countPages', $countPages);
            $this->registry['template']->set('dbData', $userDb);
            $this->registry['template']->set('typeSort', $typeSort);
            $this->registry['template']->set('sortDirection', $sortDirection);
            $this->registry['template']->show('index');
        }
        
        function create(){
            if (((isset($_POST['username']) && isset($_POST['text'])) || (isset($_SESSION['username']) && isset($_POST['text'])))) {
				$dir = opendir('../public/img');
                $count_img = 0;
                while ($file = readdir($dir)) {
                    if ($file == '.' || $file == '..' || is_dir('../public/img' . $file)) {
                        continue;
                    }
                    $count_img++;
                }
                $text = $_POST['text'];
                $messageList = array();
                $boolError = false;
                if (isset($_SESSION['username'])) {
                    $user = $_SESSION['username'];
                    if (strlen($text) < 5) {
                        array_push($messageList, 'Text must have more than 5 symbols.');
                        $boolError = true;
                    }
                } else {
                    $user = $_POST['username'];
                    if (strlen($user) < 3 || strlen($text) < 5) {
                        if (strlen($user) < 3) {array_push($messageList, 'Username must have more than 3 symbols.');}
                        if (strlen($text) < 5) {array_push($messageList, 'Text must have more than 5 symbols.');}
                        $boolError = true;
                    }
                }

                if ($boolError == false) {
                    $query = "SELECT users.id FROM users WHERE users.username = '" 
                    . $user . "'";
                    $user_id = $this->registry['db']->query($query)->fetchAll();
                    if (empty($user_id)) {
                        array_push($messageList, 'Current user does not exists.');
						$boolError = true;
                    } else {
                        $query = "INSERT INTO questionnaire VALUES (null, '"
                            . (int)$user_id[0]['id'] . "', '" . htmlspecialchars(addslashes($text)) . "', 0)";
                        if (!$this->registry['db']->query($query)) {
                            array_push($messageList, 'Invalid query');
                        } else {
                            array_push($messageList, 'You created task.');
                            $_SESSION['messages'] = $messageList;
                            header("Location: /");
                        }
                    }
                }
                $prev_values = array($user, $_POST['text']);
                $this->registry['template']->set('prev_values', $prev_values);
                $this->registry['template']->set('error', $boolError);
                $this->registry['template']->set('messages', $messageList);
            }
            $this->registry['template']->show('create');
        }
        
        function edit(){
            if (!isset($_SESSION['admin_mode']) || $_SESSION['admin_mode'] == false) {
                header("Location: /login");
                exit();
            }

            $taskId = $_POST['taskId'];
            $messageList = array();
            $boolError = false;
            $query = "SELECT questionnaire.text, questionnaire.status FROM questionnaire WHERE questionnaire.id = " 
                . $taskId;
            $text = $this->registry['db']->query($query)->fetchAll()[0]['text'];
            $status = $this->registry['db']->query($query)->fetchAll()[0]['status'];
            if (isset($_POST['text'])) {
                if (isset($_POST['status'])) {
                    $status_real = 1;
                } else {
                    $status_real = 0;
                }
                if (htmlspecialchars($_POST['text']) == $text && $status_real == $status) {
                    array_push($messageList, 'Nothing changed.');
                    $boolError = true;
                } else {
                    $query = "UPDATE questionnaire SET questionnaire.text = '" 
                        . htmlspecialchars(addslashes($_POST['text'])) . "', questionnaire.status = "
                        . $status_real . ', '
                        . 'questionnaire.edited = 1, '
                        . 'questionnaire.updated = "' . date('Y-m-d H:i:s') . '"'
                        . " WHERE questionnaire.id = " . $taskId;

                    if (!$this->registry['db']->query($query)) {
                        array_push($messageList, 'Invalid query');
                        $boolError = true;
                        
                    } else {
                        $text = $_POST['text'];
                        $status = $status_real;
                        array_push($messageList, 'Task edited.');
                        $_SESSION['messages'] = $messageList;
                        header("Location: /");
                    }
                }
            }
            $this->registry['template']->set('taskId', $taskId);
            $this->registry['template']->set('text', $text);
            $this->registry['template']->set('status', $status);
            $this->registry['template']->set('error', $boolError);
            $this->registry['template']->set('messages', $messageList);
            $this->registry['template']->show('edit');
        }
        
        function login(){
            if (isset($_SESSION['username'])) {
                unset($_SESSION['username']);
                unset($_SESSION['admin_mode']);
                $this->registry['template']->show('login');
                header("Location: /#");
            } else {
                if (isset($_POST['username']) && isset($_POST['pass'])) {
                    $user = $_POST['username'];
                    $pass = $_POST['pass'];
                    $messageList = array();
                    $boolError = false;
                    $userDb = $this->registry['db']->query("SELECT email, pass FROM users where users.username = '" . $user . "'")->fetchAll();
                    if (count($userDb) == 0) {
                        array_push($messageList, 'Username does not exist.');
                        $boolError = true;
                    } else {
                        if (hash_equals($userDb[0]['pass'], crypt($pass, $userDb[0]['pass']))) {
                            array_push($messageList, 'You successfuly logined.');
                            $_SESSION['username'] = $user;
                            if ($user == 'admin') {
                                $_SESSION['admin_mode'] = true;
                            }
                            $_SESSION['messages'] = $messageList;
                            header("Location: /");
                            return true;
                        } else {
                            array_push($messageList, 'Wrong password or username.');
                            $boolError = true;
                        }
                    }
                    $prev_values = array($user);
                    $this->registry['template']->set ('prev_values', $prev_values);
                    $this->registry['template']->set ('error', $boolError);
                    $this->registry['template']->set('messages', $messageList);
                }
                $this->registry['template']->show('login');
            }
            
        }
        
        function registration(){
            if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pass'])) {
                $user = $_POST['username'];
                $email = $_POST['email'];
                $pass = $_POST['pass'];
                $userList = $this->registry['db']->query('SELECT * FROM users')->fetchAll();
                $messageList = array();
                $boolError = false;
                if (strlen($user) < 3 || strlen($pass) < 6 || strlen($email) < 3) {
                    if (strlen($user) < 3) {array_push($messageList, 'Username must have more than 3 symbols.');}
                    if (strlen($email) < 3) {array_push($messageList, 'Email can\'t be empty');}
                    if (strlen($pass) < 6) {array_push($messageList, 'Password must have more than 6 symbols.');}
                    $boolError = true;
                }
                for ($i = 0; $i < count($userList); $i++) {
                    if ($userList[$i]['username'] == $user) {
                        array_push($messageList, 'Username already exists.');
                        $boolError = true;
                    }
                    if ($userList[$i]['email'] == $email) {
                        array_push($messageList, 'Email already exists.');
                        $boolError = true;
                    }
                }
                if ($boolError == false) {
                    $query = "INSERT INTO users VALUES (null, '"
                        . $user . "', '" . $email . "', '" . password_hash($pass, PASSWORD_DEFAULT) . "');";
                    if (!$this->registry['db']->query($query)) {
                        array_push($messageList, 'Invalid query');
                        $boolError = true;
                    } else {
                        array_push($messageList, 'Congratulations! You registred.');
                        $_SESSION['messages'] = $messageList;
                        header("Location: /");
                    }
                }
                $prev_values = array($user, $email);
                $this->registry['template']->set ('prev_values', $prev_values);
                $this->registry['template']->set ('error', $boolError);
                $this->registry['template']->set ('messages', $messageList);
            }
            $this->registry['template']->show('registration');
        }
    }
?>