<?php

// USERS

function login_user($user){
    session_regenerate_id(); // protects against session fixation.
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    return true;
}

function is_logged_in(){
    return isset($_SESSION['user_id']);
}

function require_login(){
    if(!is_logged_in()){
        $message = "Please log in to access this page";
        redirect_to(url_for('/client/login.php?message=' . $message));
    }
    else{
        // Carry on loading rest of page script
    }
}

// ADMINS

function login_admin($admin){
    session_regenerate_id(); // protects against session fixation.
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin_email'] = $admin['email'];
    return true;
}

function admin_is_logged_in(){
    return isset($_SESSION['admin_id']);
}

function require_admin_login(){
    if(!admin_is_logged_in()){
        $message = "Please log in to access this page";
        redirect_to(url_for('/admin/login.php?message=' . $message));
    }
    else{
        // Carry on loading rest of page script
    }
}

?>