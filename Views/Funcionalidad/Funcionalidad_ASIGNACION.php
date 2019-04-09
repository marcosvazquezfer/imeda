<?php

/**
 * Nos permite realizar la asignacion de funcionalidad
 * Autor: Ruben -Grupo Imeda
 * Fecha inicio: 28/11/2017
 */

    //Archivo php donde se muestra el apartado Mostrar todos los usuarios
    include_once '../Functions/Authentication.php';
    
    
    class FUNCIONALIDAD_ASIGNACION {

        function __construct($grupos,$gruposuser,$log){
            
            $this->pinta($grupos,$gruposuser,$log);

        }


//función que pinta la vista
        function pinta($grupos,$gruposuser,$log){
            //comprueba si hay un idioma en $_SESSION
            //si no, inserta el idioma español
            if(!isset($_SESSION['idioma'])){
                $_SESSION['idioma'] = 'SPANISH';
            }

            include_once '../Locales/Strings_index.php';
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
                    
                    <h4><?php echo $strings['Asignacion de acciones']; ?></h4>
                    <br>
                    <form action="../Controllers/Funcionalidad_Controller.php" method="post" enctype="multipart/form-data">

                        
                        <input type="hidden" name="IdFuncionalidad" value="<?php echo $log; ?>">
                        <?php 
                            $row2;//almacenara las acciones que están guardadas en la bd
                            $row2 = $gruposuser->fetch_all();
                            //bucle que imprime checkbox para cada accion
                            while ($row = $grupos->fetch_array()){
                                
                            ?>
                                <div>
                                <input type="checkbox" name="IdAccion[]" <?php 
                                    //bucle para todas las acciones comprobando si estaba en la base de datos marcada
                                    foreach($row2 as $ro){
                                        //si estubo marcada imprime checked
                                        if ($row['IdAccion'] == $ro[0]){
                                            echo 'checked';
                                        }
                                    }
                                
                                ?> value="<?php echo $row['IdAccion']; ?>" ><?php echo $row['NombreAccion']; ?>
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
                
                <script src="../js/main.js"></script>
                <?php include '../Views/js/validaciones.js' ?>
            </body>
            </html>
            
            <?php
        
        }
    }
?>