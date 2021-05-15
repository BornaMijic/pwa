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
                    <form class='forma1' action="" method="post">
                        <div>
                            <label>Korisničko Ime</label>
                            <div>
                                <input type="text" name="korisnickoIme" class="naslovClanka"/>
                            </div>
                        </div>
                        <div>
                            <label>Šifra</label>
                            <div>
                                <input type="password" name="sifra" class="naslovClanka"/>
                            </div>
                        </div>  
                        <div>
                           <input type='submit' name='login' value='Login'/>
                        </div>                   
                   </form> 
                   <?php
                    
                    if(isset($_POST['login'])){
                        include 'connect.php';  
                        $korisnickoIme = $_POST['korisnickoIme'];
                        $lozinka = $_POST['sifra'];
                        $query = "SELECT * FROM korisnik WHERE korisnicko_ime='$korisnickoIme' AND lozinka='$lozinka'";
                        $result = mysqli_query($dbc, $query) or die('Error querying database.'); 
                        if (mysqli_num_rows($result)>0) echo ('Uspjesan login');
                         mysqli_close($dbc); 
                    }
                     
                   ?>
                   
            </article>
        </section>
        <footer>
             <p id="copyright">@2021 Borna Mijić, bmijic@tvz.hr</p>
        </footer>
    </main>
</body>
</html>