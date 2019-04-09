<?php

/**
 * Archivo php donde se muestra el menu
 * Autor: Alex -Grupo Imeda
 * Fecha: 28/11/2017
 */
    include_once '../Functions/Authentication.php';

    class Aside {

        function __construct(){

            $this->pinta();

        }

    
        //función que contiene la vista
        function pinta(){

            //comprueba si hay un idioma en $_SESSION
            //si no, inserta el idioma español
            if(!isset($_SESSION['idioma'])){
                $_SESSION['idioma'] = 'SPANISH'; 
            }
    
            include '../Locales/Strings_index.php';
            
            $stringslang;//almacena idioma
            $lang;//almacena el idioma en uso

            //bucle foreach que comprueba que idioma esta seleccionado para cargar los strings
            foreach($stringslang as $lang){
                //Comprueba que idioma está seleccionado y carga el strings correspondiente
                if($lang == $_SESSION['idioma'])
                    include '../Locales/Strings_'. $lang .'.php';
            }

            ?>
    
            <aside id="menu">
            <div class="resp-menu-close" onclick="hide()">
                <img src="../Views/imgs/cross.png" alt="">
            </div>
                <?php if(isset($_SESSION['login'])) {?>
            <ul>
                <a href="../Controllers/Login_Controller.php">
                    <li>
                        <?php echo $strings['Inicio']; ?>
                    </li>
                </a>
               
                <li>        
                    <?php echo $strings['Control de Acceso']; ?>
                    <ul class="sub" >
                        <a href="../Controllers/ACCION_Controller.php?action=SHOWALL"><li><?php echo $strings['Acciones']; ?></li></a>
                        <a href="../Controllers/Funcionalidad_Controller.php?action=SHOWALL"><li><?php echo $strings['Funcionalidades']; ?></li></a>
                        <a href="../Controllers/Grupo_Controller.php?action=SHOWALL"><li><?php echo $strings['Grupos']; ?></li></a>
                        <a href="../Controllers/USUARIOS_Controller.php?action=SHOWALL"><li><?php echo $strings['Usuarios']; ?></li></a>
                        <a href="../Controllers/Permiso_Controller.php?action=SHOWALL"><li><?php echo $strings['Permisos']; ?></li></a>
                    </ul>
                </li>
                
                <li>
                    <?php echo $strings['Trabajos']; ?>
                    <ul class="sub" >
                        <a href="../Controllers/TRABAJO_Controller.php?action=SHOWALL"><li><?php echo $strings['Trabajos']; ?></li></a>
                        <a href="../Controllers/Entrega_Controller.php?action=SHOWALL"><li><?php echo $strings['Entregas']; ?></li></a>
                        <a href="../Controllers/AsignacionQA_Controller.php?action=SHOWALL"><li><?php echo $strings['Asignacion de QAs']; ?></li></a>
                        <a href="../Controllers/Evaluacion_Controller.php?action=MOSTRARQAS"><li><?php echo $strings['QA']; ?></li></a>
                        <a href="../Controllers/Historia_Controller.php?action=SHOWALL"><li><?php echo $strings['Historias']; ?></li></a>
                        <a href="../Controllers/Evaluacion_Controller.php?action=SHOWALL"><li><?php echo $strings['Evaluacion']; ?></li></a>
                        <a href="../Controllers/NOTAS_Controller.php?action=SHOWALL"><li><?php echo $strings['Notas']; ?></li></a>
                    </ul>
                </li>
                
                <a href="../Controllers/NOTAS_Controller.php?action=MISNOTAS">
                    <li>
                        <?php echo $strings['Resultados']; ?>
                    </li>
                </a>
                
            </ul>
            <?php } ?>
        </aside>

        <?php
        }
}

?>