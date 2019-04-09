<?php
/**
 * Vista que muestra todos los trabajos que hay en la BD
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 1/12/2017
 * Fecha fin: 1/12/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    
    class TRABAJO_SHOWALL {

        function __construct($lista,$trabajos,$message){
            
            $this->pinta($trabajos,$message);

        }

    
    //función que contiene la vista
    function pinta($trabajos,$message){
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
            if($lang == $_SESSION['idioma'])
                include_once '../Locales/Strings_'. $lang .'.php';
        }

        include '../Views/HEADER_View.php';

        new HEADER();
        ?>
            <section class="form-basic-start"> 

            <div class="showall">
    
                <div >
                    <form action="../Controllers/TRABAJO_Controller.php" method="">
                        <button class="showall-action" name="action" value="SEARCH" type="submit"><img src="../Views/imgs/search.png" alt="" srcset=""></button>
                        <button class="showall-action" name="action" value="ADD" type="submit"><img src="../Views/imgs/add.png" alt="" srcset=""></button>
                    </form>
                </div>
                
                <table class="showall-tab">
                    <tr>
                        <th><?php echo $strings['Id Trabajo']; ?></th>
                        <th><?php echo $strings['Nombre Trabajo']; ?></th> 
                        <th><?php echo $strings['Fecha Inicio']; ?></th>
                        <th><?php echo $strings['Fecha Fin']; ?></th>
                        <th><?php echo $strings['Porcentaje Nota']; ?></th> 
                        
                    </tr>
                    <?php 
                    
                    $row;//almacena trabajos

                    //mientras existan trabajos los imprime por pantalla en una tabla
                    while ($row = $trabajos->fetch_array()){
                        
                        ?>
                        <tr>
                            <form action="../Controllers/TRABAJO_Controller.php" method="" >
                                    <td><input type="hidden" name="IdTrabajo" value="<?php echo $row['IdTrabajo']; ?>"><?php echo $row['IdTrabajo']; ?></td>
                                    <td><?php echo $row['NombreTrabajo']; ?></td>
                                    <td><?php echo $row['FechaIniTrabajo']; ?></td>
                                    <td><?php echo $row['FechaFinTrabajo']; ?></td>
                                    <td><?php echo $row['PorcentajeNota']; ?></td>
                                    <td>
                                        <button class="showall-action" name="action" value="SHOWCURRENT" type="submit"><img src="../Views/imgs/detail.png" alt="" srcset=""></button>
                                        <button class="showall-action" name="action" value="EDIT" type="submit"><img src="../Views/imgs/edit.png" alt="" srcset=""></button>
                                        <button class="showall-action" name="action" value="DELETE" type="submit"><img src="../Views/imgs/delete.png" alt="" srcset=""></button>
                            </form>


                                    </td>
                                    <td>
                                        <form action="../Controllers/Entrega_Controller.php" method="" >
                                            <input type="hidden" name="login" id="login" value="<?php echo $_SESSION['login']?>">
                                            <input type="hidden" name="IdTrabajo" value="<?php echo $row['IdTrabajo']; ?>">
                                            <input type="hidden" name="FechaFinTrabajo" value="<?php echo $row['FechaFinTrabajo'];?>">
                                            <input type="hidden" name="FechaIniTrabajo" value="<?php echo $row['FechaIniTrabajo'];?>">
                                            <button class="showall-action" name="action" value="" type="submit"><img src="../Views/imgs/arrow.png" alt="" srcset=""></button>
                                        </form>
                                    </td>
                        </tr>

                        <?php
                    }
    
                    ?>
                    
                    </table>
        
            </div>

            <a href="../Controllers/TRABAJO_Controller.php?action=default">
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