<?php

class SessionManager{

    function __constructor(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
      
    }

    function login_session() : bool{
        if(!session_id()){
            session_start();
            session_regenerate_id(true);
            return true;
        }
        return false;
    }

    function clean_session(): void{
        session_unset();
        session_destroy();

    }

    function is_logged():bool
    {
    if(isset($_SESSION['username']) || isset($_SESSION['name'])){
        return true;}
    return false;  
    }

    function is_admin():bool
    {
    if(is_logged())
        if(isset($_SESSION['rank']) && $_SESSION['rank'] == 1)
        return true;
    return false;
    }

    function is_instructor():bool
    {
    if(is_logged())
        if(isset($_SESSION['state_user']) && $_SESSION['state_user'] == 1)
        return true;
    return false;
    }

    function is_professor():bool
    {
    if(is_logged())
        if(isset($_SESSION['state_user']) && $_SESSION['state_user'] == 2)
        return true;
    return false;
    }


    /* ------------------ Util function ------------------ */

    function instance_session($userinfo){
    $_SESSION['username'] = $userinfo[''];
    $_SESSION['last_name'] = $userinfo[''];
    $_SESSION['passwd'] = $userinfo[''];
    $_SESSION['state_user'] = $userinfo[''];
    $_SESSION['rank'] = $userinfo[''];
    $_SESSION['admin'] = $userinfo[''];
    $_SESSION['user_id'] = $userinfo[''];
    }


}