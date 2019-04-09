<?php

/**
 * Archivo php donde se muestra el apartado Showall de evaluaciones
 * Autor: Mauri -Grupo Imeda
 * Fecha: 21/12/2017
 */

include_once '../Functions/Authentication.php';


class Evaluacion_SHOWALL{

    function __construct($qa,$message){

        $this->pinta($qa,$message);

    }


    //Muestra las vista a enseñar
    function pinta($qa,$message){

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

                <div >
                    <form action="../Controllers/Evaluacion_Controller.php" method="">
                        <button class="showall-action" name="action" value="SEARCH" type="submit"><img src="../Views/imgs/search.png" alt="" srcset=""></button>
                        <button class="showall-action" name="action" value="ADD" type="submit"><img src="../Views/imgs/add.png" alt="" srcset=""></button>
                    </form>

                </div>

                <table class="showall-tab">
                    <tr>

                        <th><?php echo $strings['Id Trabajo']; ?></th>
                        <th><?php echo $strings['Id Historia']; ?></th>
                        <th><?php echo $strings['Login Evaluador']; ?></th>
                        <th><?php echo $strings['Alias Evaluado']; ?></th>

                        <th>
                        </th>
                    </tr>
                    <?php
                    //recorre todas las evaluaciones existentes
                    while ($row = $qa->fetch_array()){
                        ?>
                        <tr>
                            <form action="<?php echo $message; ?>" method="" >
                                <td><input type="hidden" name="IdTrabajo" value="<?php echo $row['IdTrabajo']; ?>"><?php echo $row['IdTrabajo']; ?></td>
                                <td><input type="hidden" name="IdHistoria" value="<?php echo $row['IdHistoria']; ?>"><?php echo $row['IdHistoria']; ?></td>
                                <td><input type="hidden" name="LoginEvaluador" value="<?php echo $row['LoginEvaluador']; ?>"><?php echo $row['LoginEvaluador']; ?></td>
                                <td><input type="hidden" name="AliasEvaluado" value="<?php echo $row['AliasEvaluado']; ?>"><?php echo $row['AliasEvaluado']; ?></td>
                                <td>
                                    <button class="showall-action" name="action" value="SHOWCURRENT" type="submit"><img src="../Views/imgs/detail.png" alt="" srcset=""></button>
                                    <button class="showall-action" name="action" value="DELETE" type="submit"><img src="../Views/imgs/delete.png" alt="" srcset=""></button>
                                </td>
                            </form>
                        </tr>


                        <?php
                    }

                    ?>

                </table>

            </div>

            <a href="../../Controllers/Login_Controller.php">
                <input type="image" src="../Views/imgs/return.png" name="back" width="50px" height="30px" />
            </a>


            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>

        <script src="../js/main.js"></script>
        <?php include '../Views/js/validaciones.js' ?>
        <script type="text/javascript" src="../js/tcal.js"></script>
        </body>
        </html>

        <?php

    }
}