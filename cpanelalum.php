<!DOCTYPE html>
<?php
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
if(!isset($_SESSION['user'])){
    header('Location: index.php');
}
$activo=3;
?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=PANEL?><?=TIT1?></title>
    <link rel="stylesheet" href="_css/estilosheader.css">
    <link rel="stylesheet" href="_css/estilosCpanel.css">
    <link rel="stylesheet" href="_css/footer.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!--    Incluimos las cookies-->
    
<?php
    include('_include/cookies.php');
?>
    
</head>

<body onload="move()">
<?php
    if(isset($_POST['id_user']) && $_POST['id_user'] == -1){
        header('Location: cpaneladmin.php?rm=1&rt=2&a=3');
    }
    include('_include/header.php');
?>
  
  
  <!--Inicio Contenido CPanel-->
<?php
    include('_include/conexion.php');
    
    if(!isset($_GET['rm'])){?>
           <nav id="nav1">
            <div class="icon-bar">
              <a href="cpanelalum.php?a=3&rm=1" id="enlace1" ><span><?= YAPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-check-circle ico"></i></a> 
                <a href="cpanelalum.php?a=3&rm=2" id="enlace2" ><span><?= NOPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-stop-circle ico"></i></a> 
            </div>
        </nav>
        
        <?php
       include('_include/cpanelindex.php');
    /*Fin del cpanel index
    COmienzo de proyectos publicados*/
    }else if (isset($_GET['rm']) && $_GET['rm']==1){ ?>
           <nav id="nav1">
            <div class="icon-bar">
              <a href="cpanelalum.php?a=3&rm=1" id="enlace1" class="active"><span><?= YAPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-check-circle ico"></i></a> 
                <a href="cpanelalum.php?a=3&rm=2" id="enlace2"><span><?= NOPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-stop-circle ico"></i></a> 
            </div>
            </nav>
        <section id="proypublic">
        <?php
            $user=$_SESSION['user'];
            $RESULT = consulta($conexion,"SELECT * 
                                          FROM proyectos 
                                          WHERE id_proyecto in (SELECT id_proyecto 
                                                                FROM usuproy
                                                                WHERE id_user = $user)
                                          AND mostrar = 1"); 
            $totalFilas= mysqli_num_rows($RESULT);?>
            <fieldset id="proypub">
               <legend><?=PROYOK?></legend>
            <ul>
               <?php
                $i=0;
                while($i<$totalFilas){
                    $row=mysqli_fetch_array($RESULT); 
                    $proyecto=$row['nombre_pro'];
                    $proyect=$row['name_pro'];
                    $idp=$row['id_proyecto'];
            ?>
            <li>
            <a href="proyecto.php?a=1&idp=<?=$idp?>" id="proyprof"><?php
                            if(isset($_SESSION['lang'])){
                                if($_SESSION['lang']==1){
                                    echo $proyect; 
                                }else{
                                   echo $proyecto;
                                }
                            }else{
                                echo $proyecto;
                            }  
                        ?></a>
            </li>
            <?php 
            $i++;
            } ?>
            </ul>
           </fieldset>
      
       </section>
    
        <?php
        /*Fin visualizar proyectos publicados             
    COmienzo de la pestaña de no publicados
    Mostramos los no publicados*/
    }else if (!isset($_GET['rt']) && isset($_GET['rm']) && $_GET['rm']==2){ ?>
           <nav id="nav1">
            <div class="icon-bar">
              <a href="cpanelalum.php?a=3&rm=1" id="enlace1"><span><?= YAPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-check-circle ico"></i></a> 
                <a href="cpanelalum.php?a=3&rm=2" id="enlace2" class="active"><span><?= NOPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-stop-circle ico"></i></a> 
            </div>
        </nav>
        <section id="proypublic">
        <?php
            $user=$_SESSION['user'];
            $RESULT = consulta($conexion,"SELECT * 
                                          FROM proyectos 
                                          WHERE id_proyecto in (SELECT id_proyecto 
                                                                FROM usuproy
                                                                WHERE id_user = $user)
                                          AND mostrar = 0"); 
            $totalFilas= mysqli_num_rows($RESULT);?>
            <fieldset id="proypub">
               <legend><?=PROYSTOP?></legend>
            <ul>
               <?php
                $i=0;
                while($i<$totalFilas){
                    $row=mysqli_fetch_array($RESULT); 
                    $proyecto=$row['nombre_pro'];
                    $proyect=$row['name_pro'];
                    $idp=$row['id_proyecto'];
            ?>
            <li>
            <a href="cpanelalum.php?a=1&rm=2&rt=1&idp=<?=$idp?>" id="proyprof"><?php
                            if(isset($_SESSION['lang'])){
                                if($_SESSION['lang']==1){
                                    echo $proyect; 
                                }else{
                                   echo $proyecto;
                                }
                            }else{
                                echo $proyecto;
                            }  
                        ?></a>
            </li>
            <?php 
            $i++;
            } ?>
            </ul>
           </fieldset>
      
       </section>
    <?php 
        /*pestaña de redactar*/
    }else if (isset($_GET['rm']) && $_GET['rm']==2 && isset($_GET['rt']) && $_GET['rt']==1){ 
    $idp=$_GET['idp'];
    ?>
               <nav id="nav1">
            <div class="icon-bar">
              <a href="cpanelalum.php?a=3&rm=1" id="enlace1"><span><?= YAPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-check-circle ico"></i></a> 
              <a href="cpanelalum.php?a=3&rm=2" id="enlace2" class="active"><span><?= NOPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-stop-circle ico"></i></a> 
            </div>
        </nav>
        <nav id="navAlum">
          <div class="icon-bar">
              <a href="cpanelalum.php?a=3&rm=2&rt=1&idp=<?=$idp?>" id="subenlace1" class="active"><span><?= TEXT ?></span><i class="fas fa-file-alt ico"></i></a> 
              <a href="cpanelalum.php?a=3&rm=2&rt=2&idp=<?=$idp?>" id="subenlace2"><span><?= PHOTO ?></span><i class="fas fa-images ico"></i></a> 
            </div>
        </nav>
        <section id="adduser">
           <!-- wysihtml5 parser rules -->
            <script src="/ruta-a-wysihtml5/parser_rules/advanced.js"></script>
            <!-- Library -->
            <script src="/ruta-a-wysihtml5/dist/wysihtml5-0.3.0.min.js"></script>
            <fieldset id="actual">
                <legend>Contenido actual</legend>
                <?php 
                    /*recuperamos el nombre del proyecto*/
                     $ProyAct = consulta($conexion, "select * from proyectos where id_proyecto like $idp");                                     $rowProy=mysqli_fetch_array($ProyAct);
                     $nombre_pro=$rowProy['nombre_pro'];                                                                       
                     $name_pro=$rowProy['name_pro'];
                     $contenido=$rowProy['contenido'];
                     $content=$rowProy['content'];
                    /*Ahora recuperamos el curso*/
                    $CurAct = consulta($conexion,"Select * from cursos where id_curso in (select id_curso from proyectos
                                                                                            where id_proyecto like $idp)");
                    $row=mysqli_fetch_array($CurAct);
                    $curso=$row['curso'];
                ?>
                <ul>
                    <li>
                        <p class="idioma" onclick="mostrarCont(spanish,esp)">Español <i class="fas fa-caret-down arriba icono" id="esp" class="abajo"></i></p>
                        <div id="spanish" class="oculto">
                            <?php if (file_exists('_cursos/'.$curso.'/'.$nombre_pro.'/'.$contenido.'')){
                            include('_cursos/'.$curso.'/'.$nombre_pro.'/'.$contenido.'');
                }else{?>
                   <p>No contenido disponible</p>
                    
                <?php }?>
                        </div>
                    </li>
                    <li>
                    <p class="idioma" onclick="mostrarCont(english,eng)">Ingles <i class="fas fa-caret-down arriba icono" id="eng" class="abajo"></i></p>
                        <div id="english" class="oculto" id="english">
                            <?php if (file_exists('_cursos/'.$curso.'/'.$nombre_pro.'/'.$content.'')){
                            include('_cursos/'.$curso.'/'.$nombre_pro.'/'.$content.'');
                }else{?>
                   <p>Not avaible content</p>
                    
                <?php }?>
                        </div>
                    </li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Redactar artículo</legend>
                <form action="">
                   <select name="idioma" id="idioma">
                       <option value="-1">Selecciona idioma</option>
                       <option value="1es.php">Español</option>
                       <option value="1en.php">Inglés</option>
                   </select>
                    <script src="ckeditor_4.9.2_bd5767ce8fc7/ckeditor/ckeditor.js"></script>
                    <div id="textoenr">
                    <textarea name="editor1" id="editor1"></textarea>
                    </div>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
               <button type="submit"><i class="fas fa-upload ico"></i></button>
                </form>
            </fieldset>
        </section>
    <?php
        /*termina redactar proyecto
        comienza subir imagenes*/
    }else if(isset($_GET['rm']) && $_GET['rm']==2 && isset($_GET['rt']) && $_GET['rt']==2){ 
    $idp=$_GET['idp'];
    ?>
                   <nav id="nav1">
            <div class="icon-bar">
              <a href="cpanelalum.php?a=3&rm=1" id="enlace1"><span><?= YAPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-check-circle ico"></i></a> 
              <a href="cpanelalum.php?a=3&rm=2" id="enlace2" class="active"><span><?= NOPUB ?></span><i class="fas fa-file ico"></i><i class="far fa-stop-circle ico"></i></a> 
            </div>
        </nav>
        <nav id="navAlum">
          <div class="icon-bar">
              <a href="cpanelalum.php?a=3&rm=2&rt=1&idp=<?=$idp?>" id="subenlace1" ><span><?= TEXT ?></span><i class="fas fa-file-alt ico"></i></a> 
              <a href="cpanelalum.php?a=3&rm=2&rt=2&idp=<?=$idp?>" id="subenlace2" class="active"><span><?= PHOTO ?></span><i class="fas fa-images ico"></i></a>  
            </div>
        </nav>
        <section id="adduser">
            <fieldset id="fotosact"> 
                <legend>Fotos ya subidas</legend>
                <?php 
        /*recuperamos el nombre del proyecto*/
                     $ProyAct = consulta($conexion, "select * from proyectos where id_proyecto like $idp");                                   $rowProy=mysqli_fetch_array($ProyAct);
                     $nombre_pro=$rowProy['nombre_pro']; 
        /*recuperamos las imagenes*/
                $imgAct= consulta($conexion,"SELECT * from imgproy where id_proyecto like $idp");
                $totalImg= mysqli_num_rows($imgAct);
        /*Ahora recuperamos el curso*/
                    $CurAct = consulta($conexion,"Select * from cursos where id_curso in (select id_curso from proyectos
                                                                                            where id_proyecto like $idp)");
                    $row=mysqli_fetch_array($CurAct);
                    $curso=$row['curso'];
                if($totalImg == 0){?>
                    <p>Aun no hay fotos</p>
                <?php }else{?>
                <table>
                    <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    </tr>
                    <?php
                    while($img= mysqli_fetch_array($imgAct)){
                    $imagen=$img['imagen'];
                    ?>
                       <tr>
                        <td>
                            <img src="_cursos/<?=$curso?>/<?=$nombre_pro?>/<?=$imagen?>" alt="" width="150">
                        </td>
                        <td><?=$imagen?></td>
                    </tr>
                    <?php }
                    ?>
                </table>
                <?php }?>
            </fieldset>
            <fieldset id="fotosub">
                <legend>Subir fotos</legend>
<style type="text/css">
  .demo-droppable {
    background: #08c;
    color: limegreen;
    padding: 100px 0;
    text-align: center;
    border: 2px solid limegreen;
      margin: 10px auto;
      width: 95%;
  }
  .demo-droppable.dragover {
    background: #00CC71;
  }
</style>
<form method="post" id="formulario" enctype="multipart/form-data" action="subirfotos.php">
<div class="demo-droppable">
  <h3><?=DROPTEXT?></h3>
</div>
<div class="output"></div>
<script type="text/javascript">
  (function(window) {
    function triggerCallback(e, callback) {
      if(!callback || typeof callback !== 'function') {
        return;
      }
      var files;
      if(e.dataTransfer) {
        files = e.dataTransfer.files;
      } else if(e.target) {
        files = e.target.files;
      }
      callback.call(null, files);
    }
    function makeDroppable(ele, callback) {
      var input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('multiple', true);
      input.setAttribute('name','files[]');
      input.setAttribute('accept','image/*');
      input.style.display = 'none';
      input.addEventListener('change', function(e) {
        triggerCallback(e, callback);
      });
      ele.appendChild(input);
      
      ele.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.add('dragover');
      });

      ele.addEventListener('dragleave', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.remove('dragover');
      });

      ele.addEventListener('drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        ele.classList.remove('dragover');
        triggerCallback(e, callback);
      });
      
      ele.addEventListener('click', function() {
        input.value = null;
        input.click();
      });
    }
    window.makeDroppable = makeDroppable;
  })(this);
  (function(window) {
    makeDroppable(window.document.querySelector('.demo-droppable'), function(files) {
      console.log(files);
      var output = document.querySelector('.output');
      output.innerHTML = '';
      for(var i=0; i<files.length; i++) {
        if(files[i].type.indexOf('image/') === 0) {
          output.innerHTML += '<img width="130" src="' + URL.createObjectURL(files[i]) + '"/>';
        }
        output.innerHTML += '<p class="textfoto">'+files[i].name+'</p>';
      }
    });
  })(this);
</script>
               <button type="submit">Dale</button>
                </form>
            </fieldset>

            <fieldset id="fotodel">
                <legend>Eliminar fotos</legend>
            </fieldset>
        </section>
    <?php
        /*FIn de subir imagenes
        fin de la pestaña no publicados
        fin cpanel alumno*/
    }
    include('_include/footer.php');
    ?>
    <script src="_js/funciones.js"></script>
    <script src="_js/funcionescpanel.js"></script>
</body>
</html>