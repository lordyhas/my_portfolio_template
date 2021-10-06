<?php
//session_start();

class Router{
  function __contructor(){
    new SessionManager();
    /* if (session_status() === PHP_SESSION_NONE) {
      session_start();
    } */     
  }
 
      
  function get($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'GET' ){ $this->route($route, $path_to_include); }  
  }
  function post($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'POST' ){ $this->route($route, $path_to_include); }    
  }
  function put($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'PUT' ){ $this->route($route, $path_to_include); }    
  }
  function patch($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'PATCH' ){ $this->route($route, $path_to_include); }    
  }
  function delete($route, $path_to_include){
    if( $_SERVER['REQUEST_METHOD'] == 'DELETE' ){ $this->route($route, $path_to_include); }    
  }
  function any($route, $path_to_include){ $this->route($route, $path_to_include); }

  private function route($route, $path_to_include){
    $ROOT = $_SERVER['DOCUMENT_ROOT'];
    if($route == "/404"){
      include_once("$ROOT/$path_to_include");
      exit();
    }  
    $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
    $request_url = rtrim($request_url, '/');
    $request_url = strtok($request_url, '?');
    $route_parts = explode('/', $route);
    $request_url_parts = explode('/', $request_url);
    array_shift($route_parts);
    array_shift($request_url_parts);
    if( $route_parts[0] == '' && count($request_url_parts) == 0 ){
      include_once("$ROOT/$path_to_include");
      exit();
    }
    if( count($route_parts) != count($request_url_parts) ){ return; }  
    $parameters = [];
    for( $__i__ = 0; $__i__ < count($route_parts); $__i__++ ){
      $route_part = $route_parts[$__i__];
      if( preg_match("/^[$]/", $route_part) ){
        $route_part = ltrim($route_part, '$');
        array_push($parameters, $request_url_parts[$__i__]);
        $$route_part=$request_url_parts[$__i__];
      }
      else if( $route_parts[$__i__] != $request_url_parts[$__i__] ){
        return;
      } 
    }
    include_once("$ROOT/$path_to_include");
    exit();
  }
  function out($text){echo htmlspecialchars($text);}
  function set_csrf(){
    $csrf_token = bin2hex(random_bytes(25));
    $_SESSION['csrf'] = $csrf_token;
    echo '<input type="hidden" name="csrf" value="'.$csrf_token.'">';
  }
  function is_csrf_valid() : bool {
    if( ! isset($_SESSION['csrf']) || ! isset($_POST['csrf'])){ return false; }
    if( $_SESSION['csrf'] != $_POST['csrf']){ return false; }
    return true;
  }

} 








