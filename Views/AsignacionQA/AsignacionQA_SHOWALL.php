<?php

/**
 * Archivo php donde se muestra el apartado Showall de Asignacion de QA
 * Autor: Ruben -Grupo Imeda
 * Fecha: 28/11/2017
 */

    include_once '../Functions/Authentication.php';


    class AsignacionQA_SHOWALL {

        function __construct($asigQA, $message){

            $this->pinta($asigQA,$message);

        }


//función que pinta la vista
        function pinta($asigQA, $message){

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
                        <form action="../Controllers/AsignacionQA_Controller.php" method="">
                            <button class="showall-action" name="action" value="SEARCH" type="submit"><img src="../Views/imgs/search.png" alt="" srcset=""></button>
                            <button class="showall-action" name="action" value="ADD" type="submit"><img src="../Views/imgs/add.png" alt="" srcset=""></button>
                            <button class="showall-action" name="action" value="GenerarQA" type="submit"><img src="../Views/imgs/automatic.png" alt="" srcset=""></button>
                            <button class="showall-action" name="action" value="GenerarHistorias" type="submit"><img src="../Views/imgs/generaEvaluacion.png" alt="" srcset=""></button>
                        </form>

                    </div>

                    <table class="showall-tab">
                        <tr>
                            <th>Id Trabajo</th>
                            <th>Login Evaluador</th>
                            <th>Login Evaluado</th>
                            <th>Alias Evaluado</th>

                            <th>
                            </th>
                        </tr>
                        <?php
                        //bucle que imprime las opciones para todas las tuplas
                        while ($row = $asigQA->fetch_array()){


                            ?>
                            <tr>
                                <form action="<?php echo $message; ?>" method="" >
                                    <td><input type="hidden" name="IdTrabajo" value="<?php echo $row['IdTrabajo']; ?>"><?php echo $row['IdTrabajo']; ?></td>
                                    <td><input type="hidden" name="LoginEvaluador" value="<?php echo $row['LoginEvaluador']; ?>"><?php echo $row['LoginEvaluador']; ?></td>
                                    <td><input type="hidden" name="LoginEvaluado" value="<?php echo $row['LoginEvaluado']; ?>"><?php echo $row['LoginEvaluado']; ?></td>
                                    <td><input type="hidden" name="AliasEvaluado" value="<?php echo $row['AliasEvaluado']; ?>"><?php echo $row['AliasEvaluado']; ?></td>
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

                <a href="../../Controllers/AsignacionQA_Controller.php?action=default">
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