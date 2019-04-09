<?php

/**
 * Vista que nos permite ver en detalle los datos de un usuario
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */

//Archivo php donde se muestra el apartado Usuario Detallado: yn8idg, Fecha: 11/11/2017
    class USUARIOS_SHOWCURRENT {

        function __construct($user){

            $this->pinta($user);

        }

    
    //función que contiene la vista
    function pinta($user){
        //comprueba si hay un idioma en $_SESSION
        //si no, inserta el idioma español
        if(!isset($_SESSION['idioma'])){
            $_SESSION['idioma'] = 'SPANISH'; 
        }

        include_once '../Locales/Strings_index.php';

        $stringslang;//almacena idioma
        $lang;//almacena el idioma en uso

        //bucle foreach que comprueba que idioma esta seleccionado para cargar los strings
        foreach($stringslang as $lang){
            //Comprueba que idioma está seleccionado y carga el strings correspondiente
            if($lang == $_SESSION['idioma'])
                include_once '../Locales/Strings_'. $lang .'.php';
        }

        include '../Views/HEADER_View.php';

        new HEADER();
        ?>
            
            <section>
                    
            <div class="form2">
                <h4><?php echo $strings['ShowCurrent']; ?></h4> 
                <ul>
                    <li>
                        <h5><?php echo $strings['Login']; ?></h5>
                        <span> <?php echo $user['login']; ?> </span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Password']; ?></h5>
                        <span><?php echo $user['password']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['DNI']; ?></h5>
                        <span> <?php echo $user['DNI']; ?> </span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Name']; ?></h5>
                        <span><?php echo $user['Nombre']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Surname']; ?></h5>
                        <span><?php echo $user['Apellidos']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Email']; ?></h5>
                        <span><?php echo $user['Correo']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Phone']; ?></h5>
                        <span><?php echo $user['Telefono']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Adress']; ?></h5>
                        <span><?php echo $user['Direccion']; ?></span>
                    </li>
                    

                </ul>
                <div class="boton-grup">
                    
                    <form action="../Controllers/USUARIOS_Controller.php" method="">
                        <button name="action" value="" type="submit" class="boton-env">
                            <img src="../Views/imgs/ok.png" alt="">
                        </button>
                    </form>
                    
                </div>
                
            </div>    
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
            </section>
            <script src="../js/main.js"></script>
            <?php include '../Views/js/validaciones.js' ?>
        </body>
        </html>
        
        <?php
    
        }
    }
?>