<?php

/**
 * Nos permite realizar la asignacion de grupos para cada usuario
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 01/11/2017
 * Fecha fin:
 */

    //Archivo php donde se muestra el apartado Mostrar todos los usuarios
    include_once '../Functions/Authentication.php';
    
    
    class USUARIOS_ASIGNACION {

        function __construct($grupos,$gruposuser,$log){
            
            $this->pinta($grupos,$gruposuser,$log);

        }

    
        //función que contiene la vista
        function pinta($grupos,$gruposuser,$log){

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
                        
                <section > 

                <div class="form2">
                    
                    <h4>Asignacion de grupos</h4>
                    <form action="../Controllers/USUARIOS_Controller.php" method="post" enctype="multipart/form-data">

                        
                        <input type="hidden" name="login" value="<?php echo $log; ?>">
                        <?php 

                            $row2;//almacena todos los grupos a los que pertenece un usuario
                            $row;//almacena grupos

                            $row2 = $gruposuser->fetch_all();
                            //mientras existan elementos
                            while ($row = $grupos->fetch_array()){
                                
                            ?>
                                <div>
                                <input type="checkbox" name="IdGrupo[]" <?php 
                                    
                                    //bucle foreach que comprueba que IdGrupo esta seleccionado para cargar la información
                                    foreach($row2 as $ro){
                                        //comprueba el IdGrupo y lo selecciona
                                        if ($row['IdGrupo'] == $ro[0]){
                                            echo 'checked';
                                        }
                                    }
                                
                                ?> value="<?php echo $row['IdGrupo']; ?>" ><?php echo $row['NombreGrupo']; ?></input>
                                </div>
                            <?php
                            }       
    
                        ?>

                               
                        <button name="action" value="ASIGNACION" type="submit" class="boton-env">
                            <img src="../Views/imgs/send.png" alt="">
                        </button>

                    </form>
                        
                </div>
            
                
                <footer>
                    <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                    <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
                </footer>
                </section>
                
                <script src="../js/md5.js"></script>
                <script src="../js/main.js"></script>
                <?php include '../Views/js/validaciones.js' ?>
            </body>
            </html>
            
            <?php
        
        }
    }
?>