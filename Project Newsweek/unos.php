<!DOCTYPE html>
<html lang="en">
<head>
    <title>NewsWeek</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <main class="page-wrapper">
        <header>
            <div class="bojaNaslovnogDijela">
                <p id="trenutnoVrijeme"><?php echo date('D, M d,Y');?></p>
                <h1 class="naslov">Newsweek</h1>   
                <div class="odjava"><?php 
                session_start();
                if(isset($_SESSION['$username']) && isset($_SESSION['$level'])){
                     echo '<form   method="post" action=""><input type="submit" name="odjava" value="odjava"/></form>';
                } ?></div>   
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="crtaNav" >Home</a></li>
                    <li><a href="kategorija.php?id=U.S" class="crtaNav">U.S</a></li>
                    <li><a href="kategorija.php?id=World" class="crtaNav">World</a></li>
                    <?php
                       if(isset($_SESSION['$username']) && isset($_SESSION['$level'])){
                        echo '<li><a href="administracija.php" class="crtaNav">Administracija</a></li>';
                        echo '<li><a href="unos.php" id="crtaNav">Unos</a></li>';
                       } else {
                        echo '<li><a href="administracija.php" class="crtaNav">Login</a></li>';
                        echo '<li><a href="registracija.php" id="crtaNav">Registracija</a></li>';
                       }
                    ?>
                  </ul>
            </nav>
        </header>
        <section>
        <?php
           
           if(isset($_POST['odjava'])){
               unset($_SERVER['$username']);
               unset($_SERVER['$level']);
               session_destroy();
               $location = "/Project Newsweek/administracija.php";
               header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
               
           }
        ?>
            <article class="flex-container crtaIznadArticla">
                    <?php
                    if(isset($_SESSION['$username']) && $_SESSION['$level'] == 0){
                        echo "<p> Dobrodošli," . $_SESSION['$username'] . ". Uspješno ste se prijavili, ali niste
                        administrator<br/>";
                    } else if(isset($_SESSION['$username']) && $_SESSION['$level'] == 1){
                        echo '<form class="forma1" method="POST" action="skripta.php" enctype="multipart/form-data">
                        <div>
                            <label>Naslov članka</label>
                            <div>
                                <input type="text" id="naslov" name="naslov" class="naslovClanka"/>
                            </div>
                            <span id="porukaNaslov" class="pogreska"></span>
                        </div>
                        <div> 
                            <label for="content">Sadržaj vijesti</label> 
                            <div> 
                                <textarea name="content" id="tekst" cols="30" rows="10"></textarea>
                            </div> 
                            <span id="porukaTekst" class="pogreska"></span>
                        </div>
                        <div> 
                            <label for="pphoto">Slika: </label> 
                            <div> 
                                <input id="pphoto" class="odabirSlika" type="file" accept="image/*" name="pphoto"/>
                            </div>
                            <span id="porukaSlika" class="pogreska"></span> 
                        </div>
                        <div> 
                            <label for="category">Kategorija vijesti</label>
                            <div> 
                                <select class="optionDio" name="category" id="kategorija">
                                   <option value="" disabled selected>Odabir kategorije</option> 
                                   <option value="U.S">U.S</option> 
                                   <option value="World">World</option>
                                </select>
                            </div> 
                            <span id="porukaKategorija" class="pogreska"></span>
                        </div>
                        <div> 
                            <label>Spremiti u arhivu: 
                                <div> 
                                    <input type="checkbox" name="archive"> 
                                </div> 
                            </label> 
                        </div> 
                        <div > 
                            <button type="reset" value="Poništi">Poništi</button> 
                            <button type="submit" name="submit" value="Prihvati" id="gumb">Prihvati</button> 
                        </div>                       
                   </form> ';
                    } else {
                        echo "<p> Da bi pristupili ovoj stranici treba te se prijaviti kao admin</br>";
                        echo "<a href='administracija.php'>Prijavite se</a>";
                    }
                    ?>

                   <script type="text/javascript"> 
                   document.getElementById("gumb").onclick = function(event) { 
                    var slanjeForme = true; 
                        var poljeNaslov = document.getElementById("naslov"); 
                        var naslov = document.getElementById("naslov").value; 
                        if (naslov.length < 5 || naslov.length > 80) { 
                            slanjeForme = false; poljeNaslov.style.border="1px dashed red"; 
                            document.getElementById("porukaNaslov").innerHTML="Naslov vjesti mora imati između 5 i 80 znakova!<br>"; 
                        } else { 
                            poljeNaslov.style.border="1px solid black"; 
                            document.getElementById("porukaNaslov").innerHTML=""; 
                        }
                        var poljeTekst = document.getElementById("tekst"); 
                        var tekst= document.getElementById("tekst").value; 
                        if (tekst.length == 0) { 
                            slanjeForme = false; 
                         poljeTekst.style.border="1px dashed red"; 
                            document.getElementById("porukaTekst").innerHTML="Sadržaj mora biti unesen!<br>"; 
                        } else { 
                         poljeTekst.style.border="1px solid black";
                            document.getElementById("porukaTekst").innerHTML=""; 
                        }
                        var poljeSlika = document.getElementById("pphoto"); 
                        var slika = document.getElementById("pphoto").value; 
                        if (slika.length == 0) { 
                            slanjeForme = false; 
                            poljeSlika.style.border="1px dashed red"; 
                            document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>"; 
                        } else { poljeSlika.style.border="1px solid black"; 
                          document.getElementById("porukaSlika").innerHTML=""; 
                        }
                        var poljeKategorija = document.getElementById("kategorija"); 
                        if(document.getElementById("kategorija").selectedIndex == 0) { 
                            slanjeForme = false; 
                            poljeKategorija.style.border="1px dashed red"; 
                            document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>"; 
                        } else { 
                            poljeKategorija.style.border="1px solid black"; 
                            document.getElementById("porukaKategorija").innerHTML=""; 
                        } 
                        if (slanjeForme != true) { event.preventDefault(); } }; 
                    </script>
            </article>
        </section>
        <footer>
             <p id="copyright">@2021 Borna Mijić, bmijic@tvz.hr</p>
        </footer>
    </main>
</body>
</html>