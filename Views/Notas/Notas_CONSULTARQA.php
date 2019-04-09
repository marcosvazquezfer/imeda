<?php

/**
 * Vista que muestra las notas de los trabajos de qa en detalle 
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    
    class NOTAS_CONSULTARQA {

        function __construct($datos,$historia){
            
            $this->pinta($datos,$historia);

        }

    
    //Muestra las vista a enseñar
    function pinta($datos,$historia){

        $datos; //Variable que guarda todos las evaluaciones
        $historia; //Variables que guarda todas las historias
        $k; //Variable que se usa de indice que se incrementa por cada login evaluador de cada historia
        $r; //Variable que se usa de indice para guardar por referencia en $ids
        $p; //Variable que se usa de indice que se incrementa por cada historia
        $ids; //Variable que guarda las tuplas relacionadas a una historia
        $i; //Variable que se usa de indice 

        //Comprueba si existe la variable en sesion para idioma y sino la crea
        if(!isset($_SESSION['idioma'])){
            $_SESSION['idioma'] = 'SPANISH';
        }

        include_once '../Locales/Strings_index.php';
        //recorre todos los posibles idiomas existentes 
        foreach($stringslang as $lang){
            //Comprueba cual es el idioma de la sesion y busca si coincide con $lang
            if($lang == $_SESSION['idioma'])
                include_once '../Locales/Strings_'. $lang .'.php';
        }

        include '../Views/HEADER_View.php';

        new HEADER();
        ?>
            <section class="form-basic-start">
            
                            <div class="showall">
            
            
                            <table  class="showall-tab">
                                <tbody>
                                
                                
                                   
                                    <?php $k=0;  
                                    /*Recorre todas las historias que se han recogido*/
                                    while($row = $historia->fetch_array()){
        
                                        $ids = array();
                                        $r=0;
                                        $p=0;
                                    
                                        //Se recorre todos las tuplas de evaluacion
                                        foreach ($datos as $item){

                                            //Comprueba si el id de historia son iguales en el array de $historia y en el de $datos
                                            //Si es asi mete en $ids la tupla de evalaucion
                                            if($item['IdHistoria'] == $row['IdHistoria']){
                                                $ids[$r] = $item;
                                                $r++;
                                            }
                                            
                                        }
                                        
                                     ?>
                                     <td colspan="5">
                                        <p><?php echo $row['IdHistoria'] ?>. <?php echo $row['TextoHistoria'] ?></p>
                                    </td>
                                    <tr>
                                        <td><?php echo $strings['Tu respuesta']; ?></td>
                                        <td><?php echo $strings['Tu comentario']; ?></td>
                                        <td><?php echo $strings['Respuesta Correcta']; ?></td>
                                        <td><?php echo $strings['Comentario Correcto']; ?></td>
                                    </tr>
                                     <?php
                                    
                
                                        $i=0;
                                        $check=0;
                                       
                                        
                                            
                                    ?>
                                    
                                    <tr>
                                        <td colspan="1">
                                            <?php
                                            //Si el valor de la correcion del alumno es 1 muestra una imagen de correcto
                                            if($ids[0]['CorrectoA'] == 1){
                                                ?> 
                                                    <img  class="showall-action" src="../Views/imgs/correcto.png" alt="">
                                                <?php
                                            //Sino muestra una imagen de error
                                            }else{
                                                ?> 
                                                    <img  class="showall-action" src="../Views/imgs/incorrecto.png" alt="">
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td><p style="max-width: 250px;"><?php echo $ids[$i]['ComenIncorrectoA'] ?></p></td>
                                        <td colspan="1">
                                            <?php
                                            //Si el valor de la correcion del profesor es 1 muestra una imagen de correcto
                                            if($ids[0]['CorrectoP'] == 1){
                                                ?> 
                                                    <img  class="showall-action" src="../Views/imgs/correcto.png" alt="">
                                                <?php
                                                //Sino muestra una imagen de error
                                            }else{
                                                ?> 
                                                    <img  class="showall-action" src="../Views/imgs/incorrecto.png" alt="">
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td><p style="max-width: 250px;"><?php echo $ids[$i]['ComentIncorrectoP'] ?></p></td>
                                    </tr>
                                       
                                    <tr>
                                        
                                    </tr>
                                    <tr>
                                    
                                    </tr>
                                    
                                    
                                    <tr>
                                        <td colspan="5">
                                            &nbsp;
                                            &nbsp;
                                        </td>
                                        
                                    </tr>
                                    <?php
                                        $k++;
                                    } 
                                    ?>
                                </tbody>
                            </table>
                            <form action="../Controllers/NOTAS_Controller.php">
                                <button name="action" value="" type="submit" class="boton-env">
                                    <img src="../Views/imgs/return.png" alt="">
                                </button>
                            </form>
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