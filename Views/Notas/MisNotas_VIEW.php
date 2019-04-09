<?php

/**
 * Vista que muestra todas las notas de los trabajos que hay en la BD
 * Autor: Marcos - Grupo Imeda
 * Fecha inicio: 21/12/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    class MisNotas_VIEW{

        function __construct($trabajos){
            
            $this->pinta($trabajos);

        }

    //función que contiene la vista
    function pinta($trabajos){
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

                <table class="showall-tab">
                    <tr>
                        <th><?php echo $strings['Id Trabajo']; ?></th>
                        <th><?php echo $strings['Nota Trabajo']; ?></th> 
                        <th><?php echo $strings['Porcentaje Nota']; ?></th>
                        <th><?php echo $strings['Nota Porcentaje']; ?></th>
                    </tr>
                    <?php

                    $notaFinal=0; //almacena la nota final
                    $trabajos;//almacena trabajos

                    //recorre todos los casos del array
                    foreach ($trabajos as $key=>$value){
                        
                        //para cada trabajo, imprime la nota, su porcentaje y la nota tras la aplicación del porcentaje
                        foreach ($trabajos[$key] as $key2 => $value2) {
                             ?>
                            <tr>
                                <form action="../Controllers/NOTAS_Controller.php" method="" >
                                        <td><input type="hidden" name="IdTrabajo" value="<?php echo $trabajos[$key][$key2]['IdTrabajo'] ?>"><?php echo $trabajos[$key][$key2][0]['IdTrabajo'] ?></td>
                                        <td><?php echo $trabajos[$key][$key2][0]['NotaTrabajo'] ?></td>
                                        <td><?php echo $trabajos[$key][$key2][0]['PorcentajeNota'] ?></td>
                                        <td><?php echo ($trabajos[$key][$key2][0]['NotaTrabajo']*(($trabajos[$key][$key2][0]['PorcentajeNota'])/100));$notaFinal=$notaFinal+$trabajos[$key][$key2][0]['NotaTrabajo']*(($trabajos[$key][$key2][0]['PorcentajeNota'])/100) ?></td>
                                </form>
                            </tr>

                        <?php
                        }
                       
                    }
    
                    ?>
                    
                    </table>

                <table class="showall-tab">

                    <tr>
                        <td><?php echo $strings['Nota Final']; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $notaFinal; ?></td>
                    </tr>
                </table>
        
            </div>
                <a href="../Controllers/Login_Controller.php">
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