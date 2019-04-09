<?php

/**
 * Vista que nos permite ver todos los usuarios añadidos
 * Autor: Lara -Grupo Imeda 
 * Fecha inicio: 29/11/2017
 * Fecha fin:29/11/2017
 */

    //Archivo php donde se muestra el apartado Mostrar todos los usuarios: yn8idg, Fecha: 11/11/2017
    include_once '../Functions/Authentication.php';
    
    
    class USUARIOS_SHOWALL {

        function __construct($users,$message){
            
            $this->pinta($users,$message);

        }

    
    //función que contiene la vista
    function pinta($users,$message){
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
                    
            <section class="form-basic-start"> 

            <div class="showall">
    
                <div >
                    <form  action="<?php echo $message; ?>" method="">
                        <button class="showall-action" name="action" value="SEARCH" type="submit"><img src="../Views/imgs/search.png" alt="" srcset=""></button>
                        <button class="showall-action" name="action" value="ADD" type="submit"><img src="../Views/imgs/add.png" alt="" srcset=""></button>
                    </form>
                        
                </div>
                
                <table class="showall-tab">
                    <tr>
                        <th><?php echo $strings['Login']; ?></th>
                        <th><?php echo $strings['DNI']; ?></th>
                        <th><?php echo $strings['Phone']; ?></th>
                        <th><?php echo $strings['Email']; ?></th>
                        <th><?php echo $strings['Name']; ?></th>
                        <th><?php echo $strings['Surname']; ?></th>
                        <th><?php echo $strings['Adress']; ?></th>
                        <th>
                        </th>
                    </tr>
                    <?php 
                    
                    $row;//almacena usuarios
                    
                    //mientras existan usuarios
                    while ($row = $users->fetch_array()){
                        
                        ?>
                        <tr>
                            <form action="../Controllers/USUARIOS_Controller.php" method="" >
                                <td><input type="hidden" name="login" value="<?php echo $row['login']; ?>"><?php echo $row['login']; ?></td>
                                <td><?php echo $row['DNI']; ?></td>
                                <td><?php echo $row['Telefono']; ?></td>  
                                <td><?php echo $row['Correo']; ?></td>
                                <td><?php echo $row['Nombre']; ?></td>
                                <td><?php echo $row['Apellidos']; ?></td>
                                <td><?php echo $row['Direccion']; ?></td>
                                <td>
                                    <button class="showall-action" name="action" value="SHOWCURRENT" type="submit"><img src="../Views/imgs/detail.png" alt="" srcset=""></button>
                                    <button class="showall-action" name="action" value="EDIT" type="submit"><img src="../Views/imgs/edit.png" alt="" srcset=""></button>
                                    <button class="showall-action" name="action" value="DELETE" type="submit"><img src="../Views/imgs/delete.png" alt="" srcset=""></button>
                                    <button class="showall-action" name="action" value="ASIGNACION" type="submit"><img src="../Views/imgs/group.png" alt="" srcset=""></button>
                                </td>
                            </form>
                        </tr>    
                        
                        
                        <?php
                    }
    
                    ?>
                    
                    </table>
            </div>
        
            <a href="../Controllers/USUARIOS_Controller.php?action=default">
                <input type="image" src="../Views/imgs/return.png" name="back" width="50px" height="30px" />
            </a>

            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
            </section>
            
            <script src="../Views/js/main.js"></script>
            <?php include '../Views/js/validaciones.js' ?>
        </body>
        </html>
        
        <?php
    
        }
    }
?>