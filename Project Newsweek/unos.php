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
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="crtaNav" >Home</a></li>
                    <li><a href="kategorija.php?id=U.S" class="crtaNav">U.S</a></li>
                    <li><a href="kategorija.php?id=World" class="crtaNav">World</a></li>
                    <li><a href="administracija.php" id="crtaNav">Administracija</a></li>
                  </ul>
            </nav>
        </header>
        <section>
            <article class="flex-container crtaIznadArticla">
                    <form method="POST" action="skripta.php" enctype="multipart/form-data">
                        <div>
                            <span id="porukaNaslov"></span>
                            <label>Naslov članka</label>
                            <div>
                                <input type="text" id="naslov" name="naslov" class="naslovClanka"/>
                            </div>
                        </div>
                        <div> 
                            <span id="porukaTekst"></span>
                            <label for="content">Sadržaj vijesti</label> 
                            <div> 
                                <textarea name="content" id="tekst" cols="30" rows="10"></textarea>
                            </div> 
                        </div>
                        <div> 
                            <span id="porukaSlika"></span>
                            <label for="pphoto">Slika: </label> 
                            <div> 
                                <input id="pphoto" type="file" accept="image/*" name="pphoto"/>
                            </div> 
                        </div>
                        <div> 
                            <span id="porukaKategorija"></span>
                            <label for="category">Kategorija vijesti</label>
                            <div> 
                                <select name="category" id="kategorija">
                                   <option value="" disabled selected>Odabir kategorije</option> 
                                   <option value="U.S">U.S</option> 
                                   <option value="World">World</option>
                                </select>
                            </div> 
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
                   </form> 

                   <script type="text/javascript"> 
                   document.getElementById("gumb").onclick = function(event) { 
                    var slanjeForme = true; 
                        var poljeNaslov = document.getElementById("naslov"); 
                        var naslov = document.getElementById("naslov").value; 
                        if (naslov.length < 5 || naslov.length > 30) { 
                            slanjeForme = false; poljeNaslov.style.border="1px dashed red"; 
                            document.getElementById("porukaNaslov").innerHTML="Naslov vjesti mora imati između 5 i 30 znakova!<br>"; 
                        } else { 
                            poljeNaslov.style.border="1px solid green"; 
                            document.getElementById("porukaNaslov").innerHTML=""; 
                        }
                        var poljeTekst = document.getElementById("tekst"); 
                        var tekst= document.getElementById("tekst").value; 
                        if (tekst.length == 0) { 
                            slanjeForme = false; 
                         poljeTekst.style.border="1px dashed red"; 
                            document.getElementById("porukaTekst").innerHTML="Sadržaj mora biti unesen!<br>"; 
                        } else { 
                         poljeTekst.style.border="1px solid green";
                            document.getElementById("porukaTekst").innerHTML=""; 
                        }
                        var poljeSlika = document.getElementById("pphoto"); 
                        var slika = document.getElementById("pphoto").value; 
                        if (slika.length == 0) { 
                            slanjeForme = false; 
                            poljeSlika.style.border="1px dashed red"; 
                            document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>"; 
                        } else { poljeSlika.style.border="1px solid green"; 
                          document.getElementById("porukaSlika").innerHTML=""; 
                        }
                        var poljeKategorija = document.getElementById("kategorija"); 
                        if(document.getElementById("kategorija").selectedIndex == 0) { 
                            slanjeForme = false; 
                            poljeKategorija.style.border="1px dashed red"; 
                            document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>"; 
                        } else { 
                            poljeKategorija.style.border="1px solid green"; 
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