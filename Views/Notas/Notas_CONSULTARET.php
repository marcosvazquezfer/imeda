<?php

/**
 * Vista que muestra las notas de los trabajos en detalle 
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 14/12/2017
 * Fecha fin: 14/12/2017
 */
    
    include_once '../Functions/Authentication.php';
    
    
    class NOTAS_CONSULTARET {

        function __construct($datos,$historia){
            
            $this->pinta($datos,$historia);

        }

    
    //Funcion que contiene la vista
    function pinta($datos,$historia){

        $datos; //Variable que guarda todos las evaluaciones
        $historia; //Variables que guarda todas las historias
        $k; //Variable que se usa de indice que se incrementa por cada login evaluador de cada historia
        $r; //Variable que se usa de indice para guardar por referencia en $ids
        $p; //Variable que se usa de indice que se incrementa por cada historia
        $ids; //Variable que guarda las tuplas relacionadas a una historia
        $brand; //Variable que guarda unj listado de login evaluadores
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
                            <tr>
                                <td colspan="5">
                                    <input type="hidden" name="IdHistoria[]" value="<?php echo $row['IdHistoria'];?>">
                                    <p><?php echo $row['IdHistoria'] ?>. <?php echo $row['TextoHistoria'] ?></p>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                    
                                    $brand = array();
                                    //Recorre las tupla de evaluacion 
                                    foreach ($datos as $item){
                                        //Si no existe la clave de login evaluador en el array brand se añade
                                        if (!array_key_exists($item['LoginEvaluador'], $brand))
                                            $brand[$item['LoginEvaluador']] = $item;
                                    }
                                    $i=0;
                                    $check=0;
                                    //Se recorre $brand que contiene el listado de los logins evaluadores de la entrega
                                    foreach($brand as $key=>$value){ 
                                        
                                ?>
                                        
                                <td style="max-width: 250px;">
                                <?php 
                                    //Si el valor de la correcion del alumno es 1 muestra una imagen de correcto
                                    if($ids[$i]['CorrectoA'] == 1){
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
                                <?php $i++; } ?>
                                    </tr>
                                    <tr>
                                    <?php
                                    
                                    $brand = array();
                                    //Recorre las tupla de evaluacion 
                                    foreach ($datos as $item){
                                        //Si no existe la clave de login evaluador en el array brand se añade
                                        if (!array_key_exists($item['LoginEvaluador'], $brand))
                                            $brand[$item['LoginEvaluador']] = $item;
                                    }
                                    $i=0;
                                    $check=0;
                                     //Se recorre $brand que contiene el listado de los logins evaluadores de la entrega
                                    foreach($brand as $key=>$value){ 
                                        
                                        ?>
                                    
                                        <td><p style="max-width: 250px;"><?php echo $ids[$i]['ComenIncorrectoA'] ?></p></td>
                                    <?php $i++; } ?>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <?php echo $strings['Comentario del Profesor']; ?>
                                        </td>
                                        <td colspan="1">
                                            <?php echo $strings['Correcto del profesor']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <textarea readonly rows="3" cols="103" maxlength="300" name="ComentIncorrectoP<?php echo $k; ?>" ><?php echo $ids[0]['ComentIncorrectoP']; ?></textarea>
                                        </td>
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