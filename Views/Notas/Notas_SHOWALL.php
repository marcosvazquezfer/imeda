<?php

/**
 * Vista que muestra todas las notas de los trabajos que hay en la BD
 * Autor: Lara -Grupo Imeda
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    
    class NOTAS_SHOWALL {

        function __construct($notas,$message){
            
            $this->pinta($notas,$message);

        }

    
    //función que contiene la vista
    function pinta($notas,$message){
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
        include_once '../Models/PERMISO_Modelo.php';
        $Permi = new PERMISO_Modelo('','','');
        new HEADER();
        ?>
            <section class="form-basic-start"> 

            <div class="showall">
     
                <div >
                    <form action="../Controllers/NOTAS_Controller.php" method="">
                        <button class="showall-action" name="action" value="SEARCH" type="submit"><img src="../Views/imgs/search.png" alt="" srcset=""></button>
                        <button class="showall-action" name="action" value="ADD" type="submit"><img src="../Views/imgs/add.png" alt="" srcset=""></button>
                        <button name="action" value="ENTREGAS" type="submit" class="showall-action">
                            <img src="../Views/imgs/notas.png" alt="">
                        </button>
                        <button name="action" value="QAS" type="submit" class="showall-action">
                            <img src="../Views/imgs/qas.png" alt="">
                        </button>
                    </form>
                </div>
                
                <table class="showall-tab">
                    <tr>
                        <th><?php echo $strings['Login']; ?></th>
                        <th><?php echo $strings['Id Trabajo']; ?></th> 
                        <th><?php echo $strings['Nota Trabajo']; ?></th> 
                        
                    </tr>
                    <?php 
                    
                    $row;//almacena notas

                    //mientras existan notas las imprime por pantalla en una tabla
                    while ($row = $notas->fetch_array()){
                        
                        ?>
                        <tr>
                            <form action="../Controllers/NOTAS_Controller.php" method="" >
                                    <td><input type="hidden" name="login" value="<?php echo $row['login']; ?>"><?php echo $row['login']; ?></td>
                                    <td><input type="hidden" name="IdTrabajo" value="<?php echo $row['IdTrabajo']; ?>"><?php echo $row['IdTrabajo']; ?></td>
                                    <td><?php echo $row['NotaTrabajo']; ?></td>
                                    <td>
                                        <button class="showall-action" name="action" value="SHOWCURRENT" type="submit"><img src="../Views/imgs/detail.png" alt="" srcset=""></button>
                                        <button class="showall-action" name="action" value="EDIT" type="submit"><img src="../Views/imgs/edit.png" alt="" srcset=""></button>
                                        <button class="showall-action" name="action" value="DELETE" type="submit"><img src="../Views/imgs/delete.png" alt="" srcset=""></button>
                                        <?php
                                            if(substr($row['IdTrabajo'],0,2)=='ET'){
                                        ?>
                                        <button class="showall-action" name="action" value="CONSULTAET" type="submit"><img src="../Views/imgs/resultados-et.png" alt="" srcset=""></button>
                                        <?php
                                            }else{
                                        ?>
                                        <button class="showall-action" name="action" value="CONSULTAQA" type="submit"><img src="../Views/imgs/resultados-qa.png" alt="" srcset=""></button>
                                        <?php
                                            }
                                        ?>
                                    </td>
                            </form>
                        </tr>

                        <?php
                    }
    
                    ?>
                    
                    </table>
        
            </div>        
            
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