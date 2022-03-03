<?php
    session_start();
    require('sql.php');

    if (isset($_POST['action']) && $_POST['action'] == 'create_message') {
        $query = "INSERT INTO reviews (user_id, context, created_at) 
                  VALUES ({$_SESSION['user_id']}, {$_POST['context']}, NOW())";
        run_mysql_query($query);
        header('Location: wall.php');
    }
    else if (isset($_POST['action']) && $_POST['action'] == 'create_comment') {
        $query = "INSERT INTO replies (review_id, user_id, content, created_at) 
                  VALUES ({$_SESSION['review_id']}, {$_SESSION['user_id']}, {$_POST['content']}, NOW())";
        run_mysql_query($query);
        header('Location: wall.php');
    }
    // $password = md5($_POST['password']);

    if (isset($_POST['action']) && $_POST['action'] == 'register') {
        register_user($_POST);
    }
    else if (isset($_POST['action']) && $_POST['action'] == 'login') {
       login_user($_POST);
    }else {
        header('location: index.php');
        die();
    }

    function register_user($post){
        $_SESSION['errors'] = array();

        if (empty($post['first_name'])) {
            $_SESSION['errors'][] = "First Name can't be blank!";
        }
        if (ctype_alpha($post['first_name']) === false) {
            $_SESSION['errors'][] = 'First Name must contain letters!';
        }
        if (strlen($post['first_name']) < 2)
        {
            $_SESSION['errors'][] = 'First Name is too short!';
        }
        if (empty($post['last_name'])) {
            $_SESSION['errors'][] = "Last Name can't be blank!";
        }
        if (ctype_alpha($post['last_name']) === false) {
            $_SESSION['errors'][] = 'Last Name must contain letters!';
        }
        if (strlen($post['last_name']) < 2)
        {
            $_SESSION['errors'][] = 'Last Name is too short!';
        }
        if (empty($post['password'])) {
            $_SESSION['errors'][] = "PASSWORD field is required!";
        }
        if ($post['password'] !== $post['confirm_password']) {
            $_SESSION['errors'][] = "PASSWORD must match to CONFIRM PASSWORD!";
        }
        if (empty($post['confirm_password'])) {
            $_SESSION['errors'][] = "CONFIRM PASSOWRD field is required!";
        }
        if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errors'][] = "Please use a valid Email Address!";
        }
        if (empty($post['contact'])) {
            $_SESSION['errors'][] = "Contact number field is required!";
        }
        if (ctype_digit($post['contact']) === false) {
            $_SESSION['errors'][] = 'Contact number must contain Numbers!';
        }
        if (strlen($post['contact']) < 8)
        {
            $_SESSION['errors'][] = 'Contact number is too short!';
        }
        if (count($_SESSION['errors']) > 0) {
            header('location: index.php');
            die();
        }else {
            $query = "INSERT INTO users (first_name, last_name, email, password, contact, created_at, updated_at)
                      VALUES ('{$post['first_name']}', '{$post['last_name']}', '{$post['email']}', '{$post['password']}', '{$post['contact']}',
                      NOW(), NOW())";
            run_mysql_query($query);
            $_SESSION['success_message'] = 'User successfuly created!';
            header('location: index.php');
            die();
        }
    }
    function login_user($post){
        // $password = md5($_POST['password']);
        $query = "SELECT * FROM users WHERE users.password = '{$post['password']}' AND users.email = '{$post['email']}'";
        $user = fetch_all($query);
        if (count($user) > 0) {
            $_SESSION['user_id'] = $user[0]['id'];
            $_SESSION['first_name'] = $user[0]['first_name'];
            $_SESSION['logged_in'] = TRUE;
            header('location: wall.php');
        }else {
            $_SESSION['errors'][] = "Can't find a user with those credentials";
            header('location: index.php');
            die();
        }
    }
?>