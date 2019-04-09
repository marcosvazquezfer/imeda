<?php
/**
 * Vista para buscar grupos
 * Autor: Marcos -Grupo Imeda
 * Fecha inicio: 29/11/2017
 * Fecha fin: 29/11/2017
 */

    class GRUPO_SEARCH {

        function __construct(){

            $this->pinta();

        }


//función que pinta la vista
    function pinta(){
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
            <section>
                    
            <div class="form">

            <?php

                ?>
                    <h3><?php echo $strings['Buscar Grupo']; ?></h3>        
                <?php
               
            ?>
            
                <form class="form-basic" enctype="multipart/form-data" method="post" action="../Controllers/Grupo_Controller.php" onsubmit="return comprobarGrupoSEARCH()">
                    <div class="form-group">
                        <label class="form-label" for="idgrupo"><?php echo $strings['Id Grupo']; ?></label>
                        <input type="text" class="form-control" maxlength="6" size="6" onblur="messagedel(this); comprobarTexto(this,6); comprobarEspacio(this)" id="idgrupo1" name="IdGrupo"  tabindex="1">
                    </div>    
                    <div class="form-group">
                        <label class="form-label" for="nombregrupo"><?php echo $strings['Nombre Grupo']; ?></label>
                        <input type="text" class="form-control" maxlength="60" size="60" onblur="messagedel(this); comprobarTexto(this,6); comprobarEspacio(this)" id="nombregrupo1" name="NombreGrupo" tabindex="1" >
                    </div> 
                    <div class="form-group">
                        <label class="form-label" for="descripgrupo"><?php echo $strings['Descripcion Grupo']; ?></label>
                        <input type="text" class="form-control" maxlength="100" size="100" onblur="messagedel(this); comprobarTexto(this,6); comprobarstartEspacio(this)" id="descripgrupo1" name="DescripGrupo" tabindex="1" >
                    </div> 
                    
                    
                    <button name="action" value="SEARCH" type="submit" class="boton-env">
                        <img src="../Views/imgs/send.png" alt="">
                    </button>
                </form>
            </div>
            <footer>
                <h6><?php echo $strings['Date']; ?>: 24/11/2017</h6>
                <h6><?php echo $strings['Author']; ?>: IMEDA</h6>
            </footer>
            </section>
            <?php include '../Views/js/Grupo_validaciones.js'; ?>
            <script src="../js/main.js"></script>
        </body>
        </html>
        
        <?php
    
        }
    }
?>