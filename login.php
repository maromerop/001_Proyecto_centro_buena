<?php
        
    include('_include/funciones.php');
    session_start();
    if(isset($_SESSION['lang'])){
        if($_SESSION['lang']==1){
            include('_include/UK-uk.php'); 
        }else{
            include('_include/ES-es.php');
            }
    }else{
        include('_include/ES-es.php');
        }
    if(isset($_SESSION['user'])){
        header('location: logout.php');
        
        exit();
    }else{    
        include('_include/conexion.php');
        //comprobar que existe $_POST
        
        if(isset($_POST['email'])  && isset($_POST['passw'])){
            //comprobar que el usuario y la contraseña coinciden con los de la BD
            
            $e=$_POST['email'];
            $p= $_POST['passw'];
            $p=md5($p);
            $ehash=md5($_POST['email']);
            $_SESSION['emailhash']=$ehash;
            $resultado= consulta($conexion, "SELECT * FROM usuarios WHERE email = '{$e}' AND password = '{$p}' AND baja like 0");
            $totalFilas=mysqli_num_rows($resultado);
            if($totalFilas == 0){
                $_SESSION['fail']=1;
                $_SESSION['msg']=PASSMAIL;
                header('Location: '.$_SESSION['urlact'].'');
            }else{
                unset($_SESSION['fail']);
                $fila= mysqli_fetch_array($resultado);
                $_SESSION['user']= $fila['id_user'];
                $_SESSION['sexo']= $fila['sexo'];
                $_SESSION['nombre']= $fila['nombre'];
                $_SESSION['email']= $fila['email'];
                $_SESSION['tipo']=$fila['tipo'];
                $_SESSION['password']=$fila['password'];
                if($p == $ehash){
                   if($_SESSION['urlact']==""){
                        header('Location: cambiapass.php');
                    }else{
                        header('Location: cambiapass.php');
                        } 
                }else if($_SESSION['urlact']==""){
                    header('Location: index.php');
                }else{
                header('Location: '.$_SESSION['urlact'].'');
                }
            }
         mysqli_close($conexion);
        }else{
            $_SESSION['fail']=1;
            $_SESSION['msg']=NOPASSMAIL;
            header('Location: '.$_SESSION['urlact'].'');
            mysqli_close($conexion);
            exit();
        }
        
    }

    