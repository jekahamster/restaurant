<?php
    
    return;
//echo "______<br>".makeValidPassword("admin2"); return; 

    function setSqlConnect() {
        global $conn, $countConnected;
       
        $host = "localhost";
        $user = "gjtrjrfv_restoran";
        $pass = "restoran123"; 
        $base = "gjtrjrfv_restoran";
        $conn = new mysqli($host, $user, $pass, $base);
        
        if ( $conn -> connect_error )
            die("Connection failed: " . $conn -> connect_error);
        $conn -> set_charset('utf8');
    }



    function checkUserName($name) {
        //return true;

        $len = strlen($name);
        if ( !(0 <= $len && $len <= 255) )
            return false;
        if ( mb_strlen($name) !== $len )
            return false;
            
        global $conn;
        if ( $conn -> escape_string($name) != $name )
            return false;

        return true;
    }



    function sqlSelectNoFetch($what, $from, $where = null, $other = null) {
        global $conn;
        $sql = "SELECT $what FROM $from";
        if ( $where !== null ) $sql .= " WHERE $where";
        if ( $other !== null ) $sql .= " $other";
            
        $res = $conn -> query($sql);
        if ( !$res ) {
            error_log($conn -> error);
            return;
        }

        return $res;
    }

    function sqlSelect($what, $from, $where = null, $other = null) {
        return sqlSelectNoFetch($what, $from, $where) -> fetch_assoc();
    }


    function makeValidPassword($pass) {
            // Просто хеш из строки (можно даже не экранировать) и рандомной соли
        return hash('sha512', $pass . "Wvkp10NSfftI");
    }

    function checkNamePass($nowUser, $userPass) {
        if ( !checkUserName($nowUser) ) {
            header("Location: https://eatforyou.tk/");
            exit;
        }

        $result = sqlSelect("password", "users", "name='$nowUser'");
        $realPass = $result['password'];
        if ( $realPass !== $userPass ) {
            session_unset();
            header("Location: https://eatforyou.tk/");
            exit;
        }
    }

    function checkSession() {
        if (session_status() == PHP_SESSION_NONE) 
            session_start();
            
        global $nowUser;
        if ( empty($_SESSION) ) 
            $nowUser = "";
        else {
            $nowUser = $_SESSION['name'];
            $userPass = $_SESSION['pass'];
            checkNamePass($nowUser, $userPass);
        }
    }

    
    function login() {
        global $name, $pass;
        checkNamePass($name, $pass);
        $x = sqlSelect("name", "users", "name='$name'");
        $name = $x['name'];
        
        $_SESSION['name'] = $name;
        $_SESSION['pass'] = $pass;
        checkSession();
    }

    
    function registration() {
        global $name, $pass;
        if ( !checkUserName($name) ) 
            goBack("err_invalid");
            
        $x = sqlSelect("name", "users", "name='$name'");
        if ( $x['name'] === $name ) 
            goBack("err_used");
        
        $ip = strval($_SERVER['REMOTE_ADDR']);
        
        global $conn;
        $sql = "INSERT INTO users(name, password, ip) 
                VALUES ('$name', '$pass', '$ip')";
        $conn -> query($sql);
    }
    
    
    function goBack($arg = null) {
        header("Location: https://eatforyou.tk/");
        exit;
    }
   
    

