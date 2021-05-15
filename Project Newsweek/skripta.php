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
        
            <?php   
               function nl2br2($string) {
                   $string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
                   return $string;
                }
               $naslov = strtoupper($_POST['naslov']);
               $kategorija = $_POST['category'];
               $sadrzaj = $_POST['content'];
               $sadrzajSParagramima = nl2br2($sadrzaj);
               
               $slika = $_FILES['pphoto']['name'];
               $t = 'img/'.$slika;
               $datum = date('n/j/y');
               
            ?>
            <header>
                <p class="razmak naslovKategorija velicinaKategorije"><?php echo $kategorija;?></p>
                <h1 class="razmak nasloviclanaka"><?php echo $naslov;?></h1>
                <p class="razmak"><?php echo $datum;?></p>
            </header>
            <article class="razmak">
                <div>
                    <?php
                       echo "<img class='slika razmak' src='". $t ."'/>";
                    ?>
                </div>
                <div class="razmak1">
                   <div id="boxKategorije">
                      <p class="velikaSlova"><?php echo $kategorija;?></p>
                   </div>
                </div>
                <p class="razmak prvoSlovo"> 
                    <?php 
                       echo $sadrzajSParagramima;
                    ?>
                </p>

            </article>
            <?php
            
                     include 'insert.php'; 
                     mysqli_close($dbc);  
            ?> 
        </section>
        <footer>
             <p id="copyright">@2021 Borna Mijić, bmijic@tvz.hr</p>
        </footer>
    </main>
</body>
</html>