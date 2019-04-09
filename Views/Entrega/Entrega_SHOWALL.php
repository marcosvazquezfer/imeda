<?php

/**
 * Vista que muestra todos los grupos que hay en la BD
 * Autor: Mauri -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */

include_once '../Functions/Authentication.php';


class Entrega_SHOWALL {

    function __construct($lista,$groups,$message){

        $this->pinta($groups,$message);

    }


//función que pinta la vista
    function pinta($groups,$message){
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
                    <form action="../Controllers/Entrega_Controller.php" method="">
                        <button class="showall-action" name="action" value="SEARCH" type="submit"><img src="../Views/imgs/search.png" alt="" srcset=""></button>
                        <button class="showall-action" name="action" value="ADD" type="submit"><img src="../Views/imgs/add.png" alt="" srcset=""></button>
                    </form>
                </div>
                <table class="showall-tab">
                    <tr>
                        <th><?php echo $strings['Id Trabajo']; ?></th>
                        <th><?php echo $strings['login']; ?></th>
                        <th><?php echo $strings['Alias']; ?></th>
                        <th><?php echo $strings['Horas']; ?></th>
                        <th><?php echo $strings['Ruta']; ?></th>
                    </tr>
                    <?php
                    //bucle que imprime la tabla para cada tupla
                    while ($row = $groups->fetch_array()){

                        ?>
                        <tr>
                            <form action="../Controllers/Entrega_Controller.php" method="" >
                                <td><input type="hidden" name="IdTrabajo" value="<?php echo $row['IdTrabajo']; ?>"><?php echo $row['IdTrabajo']; ?></td>
                                <td><input type="hidden" name="login" value="<?php echo $row['login'];?>"><?php echo $row['login']; ?></td>
                                <td><?php echo $row['Alias']; ?></td>
                                <td><?php echo $row['Horas']; ?></td>
                                <td><a href="<?php echo $row['Ruta']?>"><?php echo $row['Ruta']?></a></td>
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

            <a href="../Controllers/Entrega_Controller.php?action=default">
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