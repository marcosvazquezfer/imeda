<?php

/**
 * Vista que muestra todos los grupos que hay en la BD
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    
    class GRUPO_SHOWALL {

        function __construct($lista,$groups,$message){
            
            $this->pinta($groups,$message);

        }


//función que pinta la vista
    function pinta($groups,$message){
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
            <section class="form-basic-start"> 

            <div class="showall">
    
                <div >
                    <form action="../Controllers/Grupo_Controller.php" method="">
                        <button class="showall-action" name="action" value="SEARCH" type="submit"><img src="../Views/imgs/search.png" alt="" srcset=""></button>
                        <button class="showall-action" name="action" value="ADD" type="submit"><img src="../Views/imgs/add.png" alt="" srcset=""></button>
                    </form>
                </div>
                
                <table class="showall-tab">
                    <tr>
                        <th><?php echo $strings['Id Grupo']; ?></th>
                        <th><?php echo $strings['Nombre Grupo']; ?></th> 
                        <th><?php echo $strings['Descripcion Grupo']; ?></th> 
                        
                    </tr>
                    <?php 
                    //bucle que imprime las opciones para todas las tuplas
                    while ($row = $groups->fetch_array()){
                        
                        ?>
                        <tr>
                            <form action="../Controllers/Grupo_Controller.php" method="" >
                                    <td><input type="hidden" name="IdGrupo" value="<?php echo $row['IdGrupo']; ?>"><?php echo $row['IdGrupo']; ?></td>
                                    <td><?php echo $row['NombreGrupo']; ?></td>
                                    <td><?php echo $row['DescripGrupo']; ?></td>
                                    <td>
                                        <button class="showall-action" name="action" value="SHOWCURRENT" type="submit"><img src="../Views/imgs/detail.png" alt="" srcset=""></button>
                                        <button class="showall-action" name="action" value="EDIT" type="submit"><img src="../Views/imgs/edit.png" alt="" srcset=""></button>
                                        <button class="showall-action" name="action" value="DELETE" type="submit"><img src="../Views/imgs/delete.png" alt="" srcset=""></button>
                                    </td>
                            </form>
                        </tr>

                        <?php
                    }
    
                    ?>
                    
                    </table>
        
            </div>

            <a href="../Controllers/Grupo_Controller.php?action=default">
                <input type="image" src="../Views/imgs/return.png" name="back" width="50px" height="30px" />
            </a>
        
            
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
            </section>
            
            <script src="../js/main.js"></script>
        </body>
        </html>
        
        <?php
    
        }
    }
?>