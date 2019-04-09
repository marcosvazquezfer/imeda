<?php

/**
 * Vista que muestra todas las notas de los trabajos que hay en la BD
 * Autor: Grupo Imeda
 * Fecha inicio: 21/12/2017
 * Fecha fin: 21/12/2017
 */

include_once '../Functions/Authentication.php';


class Notas_Admin {

    function __construct($datosTodos,$trabajos){

        $this->pinta($datosTodos,$trabajos);

    }


    //función que contiene la vista
    function pinta($datosTodos,$trabajos){
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
                        <th><?php echo $strings['Login']; ?></th>

                        <?php
                        foreach ($trabajos as $row){
                        ?>

                        <th><?php echo $row['IdTrabajo']; ?></th>

                        <?php
                        }
                        ?>
                        <th><?php echo $strings['Nota Final']; ?></th>
                    </tr>
                    <?php
                        //recorre todos los casos del array
                        foreach ($datosTodos as $key => $value) {

                            $notafinal=0; //almacenará la nota final

                            ?>
                            <tr>
                                <td><?php echo $key; ?></td>
                                <?php
                                //recorre todos los trabajos para comprobar las notas de cada persona
                                foreach ($trabajos as $row){

                                    //comprueba  que exista valor para un trabajo
                                    //si true, imprime la nota y la suma a la nota final aplicando su porcentaje
                                    //si false, imprime - y suma 0 a la nota final
                                    if(isset($value[$row['IdTrabajo']])){
                                        ?>
                                        <td><?php echo $value[$row['IdTrabajo']]['Nota']?></td>
                                        <?php
                                        $notafinal=$notafinal + $value[$row['IdTrabajo']]['Nota']*($value[$row['IdTrabajo']]['Porcentaje']/100);
                                    }else{
                                        $notafinal=$notafinal +0;
                                        ?>
                                        <td>-</td>
                                        <?php
                                    }

                                }


                            ?>

                                <td><?php echo $notafinal;?></td>
                            </tr>
                            <?php
                        }
                    ?>


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
