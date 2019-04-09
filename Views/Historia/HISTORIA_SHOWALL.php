<?php

/**
 * Vista que muestra todas las historias que hay en la BD
 * Autor: Alex -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */

include_once '../Functions/Authentication.php';


class HISTORIA_SHOWALL {

    function __construct($lista,$hist,$message){

        $this->pinta($hist,$message);

    }


    //función que contiene la vista
    function pinta($hist,$message){
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
                    <form  action="../Controllers/Historia_Controller.php" method="">
                        <button class="showall-action" name="action" value="SEARCH" type="submit"><img src="../Views/imgs/search.png" alt="" srcset=""></button>
                        <button class="showall-action" name="action" value="ADD" type="submit"><img src="../Views/imgs/add.png" alt="" srcset=""></button>
                    </form>
                </div>

                <table class="showall-tab">
                    <tr>
                        <th><?php echo $strings['Id Trabajo']; ?></th>
                        <th><?php echo $strings['Id Historia']; ?></th>
                        <th><?php echo $strings['Texto Historia']; ?></th>

                    </tr>
                    <?php

                    $row;//almacena historias

                    //mientras existan historias, las imprime en una tabla
                    while ($row = $hist->fetch_array()){

                        ?>
                        <tr>
                            <form action="../Controllers/Historia_Controller.php" method="" >
                                <td><input type="hidden" name="IdTrabajo" value="<?php echo $row['IdTrabajo']; ?>"><?php echo $row['IdTrabajo']; ?></td>
                                <td><input type="hidden" name="IdHistoria" value="<?php echo $row['IdHistoria']; ?>"><?php echo $row['IdHistoria']; ?></td>
                                <td><?php echo $row['TextoHistoria']; ?></td>
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

            <a href="../Controllers/Historia_Controller.php?action=default">
                <input type="image" src="../Views/imgs/return.png" name="back" width="50px" height="30px" />
            </a>


            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
        </section>

        <script src="../Views/js/main.js"></script>
        </body>
        </html>

        <?php

    }
}
?>