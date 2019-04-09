<?php

/**
 * Nos permite evaluar las QAS de una entrega
 * Autor: Alex -Grupo Imeda
 * Fecha: 10/12/2017
 */

class EVALUACION_EVALUARQA {

    

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

                <form action="../Controllers/Evaluacion_Controller.php" method="POST" >
                <table  class="showall-tab">
                    <tbody>
                    
                    
                       
                        <?php $k=0; /*Recorre todas las historias que se han recogido*/  while($row = $historia->fetch_array()){

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
                            <td><?php echo $strings['Login']; ?></td>
                            <td><?php echo $strings['Alumno']; ?></td>
                            <td><?php echo $strings['Profesor']; ?></td>
                            <td><?php echo $strings['Comentario del Alumno']; ?></td>
                            <td><?php echo $strings['OK']; ?></td>
                        </tr>
                        <?php
                        
                        $brand = array();
                        //Recorre las tupla de evaluacion 
                        foreach ($datos as $item){
                        //Si no existe la clave de login evaluador en el array brand se añade
                            if (!array_key_exists($item['LoginEvaluador'], $brand))
                                $brand[$item['LoginEvaluador']] = $item;
                        }
                        $i=0;

                        //Se recorre $brand que contiene el listado de los logins evaluadores de la entrega
                        foreach($brand as $key=>$value){ 
                            
                            ?>
                        <tr>
                            <td><input type="hidden" name="LoginEvaluador<?php echo $k ?>[]" value="<?php echo $ids[$i]['LoginEvaluador'];?>"><?php 
                                echo $ids[$i]['LoginEvaluador'];
                            ?> <input type="hidden" name="IdTrabajo" value="<?php echo $ids[$i]['IdTrabajo'];?>">
                                <input type="hidden" name="AliasEvaluado" value="<?php echo $ids[$i]['AliasEvaluado'];?>"> </td>
                            <td><?php 
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
                            ?> </td>
                            <td>
                            <?php 
                            
                                //Si el valor de la correcion del profesor es 1 muestra una imagen de correcto
                                if($ids[$i]['CorrectoP'] == 1){
                                    ?> 
                                        <img  class="showall-action" src="../Views/imgs/correcto.png" alt="">
                                    <?php
                                //Sino muestra una imagen de error
                                }else{
                                    ?> 
                                        <img  class="showall-action" src="../Views/imgs/incorrecto.png" alt="">
                                    <?php
                                }
                            ?></td>
                            <td><?php echo $ids[$i]['ComenIncorrectoA'] ?></td>
                            <td> <input type="checkbox" value="1" name="ok<?php echo $k; echo $p;  $p++; ?>" <?php
                            /*Si el valor es 1 muestra el checkbox como checked*/ 
                            if($ids[$i]['OK'] == 1){ echo 'checked';} ?>> </td>
                        </tr>
                        <?php $i++; } ?>
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
                                <textarea rows="3" cols="103" maxlength="300" name="ComentIncorrectoP<?php echo $k; ?>" ><?php echo $ids[0]['ComentIncorrectoP']; ?></textarea>
                            </td>
                            <td colspan="1">
                               <input type="checkbox" value="1" name="CorrectoP<?php echo $k; ?>" <?php 
                               /*Si el valor es 1 muestra el checkbox como checked*/  
                               if($ids[0]['CorrectoP'] == 1){ echo 'checked';} ?>>
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
                <button name="action" value="EVALUARQA" type="submit" class="boton-env">
                    <img src="../Views/imgs/send.png" alt="">
                </button>
                </form>
            </div>

                <a href="../Controllers/Funcionalidad_Controller.php?action=default">
                    <input type="image" src="../Views/imgs/return.png" name="back" width="50px" height="30px" />
                </a>

            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>
        <script src="../Views/js/md5.js"></script>
        <script src="../Views/js/Funcionalidades_validaciones.js"></script>
        <script src="../Views/js/main.js"></script>
        <script type="text/javascript" src="../Views/js/tcal.js"></script>
        </body>
        </html>

        <?php

    }
}
?>