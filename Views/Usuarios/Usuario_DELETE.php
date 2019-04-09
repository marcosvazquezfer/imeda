<?php

/**
 * Vista que nos permite eliminar un usuario
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */

//Archivo php donde se muestra el apartado Borrar Usuario: yn8idg, Fecha: 11/11/2017
    class USUARIOS_DELETE {

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
            <h4><?php echo $strings['Delete']; ?></h4> 
            <h4>Esta a punto de eliminar esta informacion</h4>
            <form enctype="multipart/form-data" action="../Controllers/USUARIOS_Controller.php" method="post">
                <ul>
                    <li>
                        <h5><?php echo $strings['Login']; ?></h5>
                        <span><input type="hidden" name="login" value="<?php echo $user['login']; ?>"><?php echo $user['login']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Password']; ?></h5>
                        <span><input type="hidden" name="password" value="<?php echo $user['password']; ?>"><?php echo $user['password']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['DNI']; ?></h5>
                        <span><input type="hidden" name="DNI" value="<?php echo $user['DNI']; ?>"><?php echo $user['DNI']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Name']; ?></h5>
                        <span><input type="hidden" name="Nombre" value="<?php echo $user['Nombre']; ?>"><?php echo $user['Nombre']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Surname']; ?></h5>
                        <span><input type="hidden" name="Apellidos" value="<?php echo $user['apellidos']; ?>"><?php echo $user['Apellidos']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Email']; ?></h5>
                        <span><input type="hidden" name="Correo" value="<?php echo $user['Correo']; ?>"><?php echo $user['Correo']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Phone']; ?></h5>
                        <span><input type="hidden" name="Telefono" value="<?php echo $user['Telefono']; ?>"><?php echo $user['Telefono']; ?></span>
                    </li>
                    <li>
                        <h5><?php echo $strings['Adress']; ?></h5>
                        <span><input type="hidden" name="Direccion" value="<?php echo $user['Direccion']; ?>"><?php echo $user['Direccion']; ?></span>
                    </li>
                </ul>
                <div class="boton-grup">
                    
                        <div class="boton-grup">
                            <button name="action" value="DELETE" class="boton-env">
                                <img src="../Views/imgs/delete.png" alt="">
                            </button>
                            <button name="action" value="" class="boton-env">
                                <img src="../Views/imgs/return.png" alt="" >
                            </button>
                        </div>
                </div>
            </form>
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