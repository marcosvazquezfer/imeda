<?php

/**
 * Archivo php donde se muestra el headerde nuestra pagina
 * Autor: Alex -Grupo Imeda
 * Fecha: 28/11/2017
 */
    include_once '../Functions/Authentication.php';

    class HEADER{

        function __construct(){

            $this->pinta();

        }

    //función que contiene la vista
    function pinta(){

        include '../Locales/Strings_index.php';

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="../Views/css/style.css">


            <link rel="stylesheet" type="text/css" href="../Views/css/tcal.css" />

            <link rel="stylesheet" href="../Views/css/button.css">
                
            <title>InfoSchool</title>
        </head>
        <body>
                <header>   
                        <div class="menu-dev" onclick="menu()" >
                            <img src="../Views/imgs/menu.png" alt="">
                        </div> 
                        <div class="head-sec">
                        </div>
                        <a href="../Controllers/Login_Controller.php">
                            <h1>
                                <span>GRUPO</span>
                                <span>IMEDA</span>
                            </h1>
                        </a>
                        <div class="head-sec">
                        
                            <?php
                            
                                if(IsAuthenticated()){
                            ?>

                            <div class="user" tabindex="1">
                                <img src="../Views/imgs/user_icon.png" alt="" srcset="">
                                <h5><?php echo $_SESSION['login']; ?></h5>
                                
                                <!--<ul class="sub-list">
                                    <li class="sub-list-li-edit">
                                        Desconectar
                                        <img src="imgs/close.png" alt="" srcset="">
                                    </li>
                                </ul>-->
                            </div>
                            <?php

                                }else{
                                    ?>
                                   <!-- <div class="user" tabindex="1">
                                        <img src="../imgs/user_icon.png" alt="" srcset="">
                                        <h5>Error</h5>
                                        
                                        <ul class="sub-list">
                                            <li class="sub-list-li-edit">
                                                Desconectar
                                                <img src="imgs/close.png" alt="" srcset="">
                                            </li>
                                        </ul>
                                    </div>-->
                                    <?php
                                }
                            ?>
                            <button class="lang">
                                <img src="../Views/imgs/world.png" alt="" srcset="">
                                <div class="sub-list">
                                    <form class="menu-lang" action="../Functions/SwitchLanguage.php" method="post">


                                    <?php
                                        //comprueba que idioma esta cargado y carga el String correspodiente
                                        foreach($stringslang as $lang){
                                            ?>
                                                <input type="submit" value="<?php echo $lang ?>" name="idioma">    
                                            <?php
                                        }
                                    ?>
                                    </form>
                                </div>                                
                            </button>
                            <button class="log">
                                <a href="../Functions/Disconnect.php">
                                    <img src="../Views/imgs/close.png" alt="" srcset="">
                                </a>
                            </button>
                            
                        </div>
                    </header>

                                <?php

                    include '../Views/ASIDE_View.php';
                    new Aside();

    }
       }
       ?>
