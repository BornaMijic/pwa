
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

<section class="flex-container">      
        
        <article class="crtaIznadArticla forma1">
              <?php
                  include "connect.php";
                  if(isset($_POST['reg'])){
                    $ime = $_POST['ime']; 
                    $prezime = $_POST['prezime']; 
                    $korisnickoIme = $_POST['korisnickoIme']; 
                    $lozinka = $_POST['lozinka']; 
                    $hashed_password = password_hash($lozinka, CRYPT_BLOWFISH);
                   $razina = 0; $registriranKorisnik = '';
                   $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?"; 
                   $stmt = mysqli_stmt_init($dbc); 
                   if (mysqli_stmt_prepare($stmt, $sql)) { 
                       mysqli_stmt_bind_param($stmt, 's', $korisnickoIme); 
                       mysqli_stmt_execute($stmt); 
                       mysqli_stmt_store_result($stmt); 
                  } 
                  if(mysqli_stmt_num_rows($stmt) > 0){ 
                      $postojiKorisnickoImeVec = true;
                  } else {
                     $postojiKorisnickoImeVec = false;
                      $sql = "INSERT INTO korisnik (ime, prezime,korisnicko_ime, lozinka, razina)VALUES (?, ?, ?, ?, ?)"; 
                      $stmt = mysqli_stmt_init($dbc); 
                      if (mysqli_stmt_prepare($stmt, $sql)) { 
                          mysqli_stmt_bind_param($stmt, 'ssssd', $ime, $prezime, $korisnickoIme, $hashed_password, $razina); 
                          mysqli_stmt_execute($stmt); 
                          $registriranKorisnik = true;
                      }
                      mysqli_close($dbc); 
                  }
  
                  if($registriranKorisnik == true) { 
                      echo '<p>Korisnik je uspješno registriran!</p>';
                      echo '<a href="administracija.php">Ulogiraj se!</a>' ;  
                  }else {
                    echo '<form  method="POST" action=""  enctype="multipart/form-data" >
                    <div>
                        <label>Ime:</label>
                        <div>
                            <input type="text" id="ime" name="ime"/>
                        </div>
                        <span id="porukaIme" class="pogreska"></span>
                    </div>
                    <div>
                        <label>Prezime:</label>
                        <div>
                            <input type="text" id="prezime" name="prezime"/>
                        </div>
                        <span id="porukaPrezime"></span>
                    </div>
                    <div>
                        <label>Korisničko ime:</label>
                        <div>
                            <input type="text" id="korisnickoIme" name="korisnickoIme"/>
                        </div>
                        <span id="porukaKorisnickoIme" class="pogreska"></span>';
                        if($postojiKorisnickoImeVec = true){
                            echo '<span class="pogreska">Korisničko ime je već zauzeto</span>';
                        }
                    echo '</div>
                    <div>
                        <label>Lozinka:</label>
                        <div>
                            <input type="password" id="lozinka" name="lozinka"/>
                        </div>
                        <span id="porukaLozinka" class="pogreska"></span>
                    </div>
                    <div>
                        <label>Ponovite Lozinku:</label>
                        <div>
                            <input type="password" id="ponovnaLozinka" name="ponovnaLozinka"/>
                        </div>
                        <span id="porukaPonovnaLozinka" class="pogreska"></span>
                    </div>
                   
                    <div > 
                       <input type="submit" id="registracija" name="reg" value="Registracija"/>
                    </div>   
       </form>';

                  }
                  } else {
                      echo '<form  method="POST" action=""  enctype="multipart/form-data" >
                      <div>
                          <label>Ime:</label>
                          <div>
                              <input type="text" id="ime" name="ime"/>
                          </div>
                          <span id="porukaIme" class="pogreska"></span>
                      </div>
                      <div>
                          <label>Prezime:</label>
                          <div>
                              <input type="text" id="prezime" name="prezime"/>
                          </div>
                          <span id="porukaPrezime" class="pogreska"></span>
                      </div>
                      <div>
                          <label>Korisničko ime:</label>
                          <div>
                              <input type="text" id="korisnickoIme" name="korisnickoIme"/>
                          </div>
                          <span id="porukaKorisnickoIme" class="pogreska"></span>
                      </div>
                      <div>
                          <label>Lozinka:</label>
                          <div>
                              <input type="password" id="lozinka" name="lozinka"/>
                          </div>
                          <span id="porukaLozinka" class="pogreska"></span>
                      </div>
                      <div>
                          <label>Ponovite Lozinku:</label>
                          <div>
                              <input type="password" id="ponovnaLozinka" name="ponovnaLozinka"/>
                          </div>
                          <span id="porukaPonovnaLozinka" class="pogreska"></span>
                      </div>
                     
                      <div > 
                         <input type="submit" id="registracija" name="reg" value="Registracija"/>
                      </div>   
         </form>';
         $refresh = 1;
                  }
                ?>
           <script type="text/javascript">
              document.getElementById("registracija").onclick = function(event){
                  var slanjeForme = true;
                  var okvirIme = document.getElementById("ime");
                  var ime = document.getElementById("ime").value;
      
                  if(ime.length > 0){
                      okvirIme.style.border = "1px solid black";
                      document.getElementById('porukaIme').innerHTML="";
                  }else{
                    okvirIme.style.border = "1px dashed red";
                    document.getElementById('porukaIme').innerHTML="Ime mora sadržavati barem jedan znak";
                    slanjeForme = false;
                  }

                  var okvirPrezime = document.getElementById("prezime");
                  var prezime = document.getElementById("prezime").value;
      
                  if(prezime.length > 0){
                      okvirPrezime.style.border = "1px solid black";
                      document.getElementById('porukaPrezime').innerHTML="";
                  }else{
                    okvirPrezime.style.border = "1px dashed red";
                    document.getElementById('porukaPrezime').innerHTML="Prezime mora sadržavati barem jedan znak";
                    slanjeForme = false;
                  }
                  
                  var okvirKorisnickoIme = document.getElementById("korisnickoIme");
                  var korisnickoIme = document.getElementById("korisnickoIme").value;
                  if(korisnickoIme.length > 0){
                    okvirKorisnickoIme.style.border = "1px solid black";
                      document.getElementById('porukaKorisnickoIme').innerHTML="";
                  }else{
                    okvirKorisnickoIme.style.border = "1px dashed red";
                    document.getElementById('porukaKorisnickoIme').innerHTML="Korisničko ime mora sadržavati barem jedan znak<br/>";
                    slanjeForme = false;
                  }

                  var okvirLozinke= document.getElementById("lozinka");
                  var lozinka = document.getElementById("lozinka").value;
                  var okvirPonovljenjeLozinke = document.getElementById("ponovnaLozinka");
                  var ponovljenaLozinka = document.getElementById("ponovnaLozinka").value;
                  if(lozinka.length > 0 && ponovljenaLozinka.length > 0 && lozinka == ponovljenaLozinka){
                    document.getElementById("porukaLozinka").innerHTML="";
                      document.getElementById("porukaPonovnaLozinka").innerHTML="";
                      okvirLozinke.style.border = "1px solid black";
                      okvirPonovljenjeLozinke.style.border = "1px solid black";
                  } else {
                    document.getElementById("porukaLozinka").innerHTML="Lozinka ili je prekratka ili lozinka nije ista ponovljenoj lozinci";
                      document.getElementById("porukaPonovnaLozinka").innerHTML="Lozinka ili je prekratka ili lozinka nije ista ponovljenoj lozinci";
                      okvirLozinke.style.border = "1px dashed red";
                      okvirPonovljenjeLozinke.style.border = "1px dashed red";
                      slanjeForme = false;
                      
                  }
                  if(slanjeForme != true){
                      event.preventDefault();
                  }
              };
           </script>

            
        </article>
</section>
        


        

        
    </main>
</body>
</html>