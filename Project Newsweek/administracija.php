<!DOCTYPE html>
<html lang="en">
<head>
    <title>NewsWeek</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="jquery-1.11.0.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="js/form-validation.js"></script>
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
            </div>
            <nav>
                <ul>
                    <li><a href="index.php" class="crtaNav" >Home</a></li>
                    <li><a href="kategorija.php?id=U.S" class="crtaNav">U.S</a></li>
                    <li><a href="kategorija.php?id=World" class="crtaNav">World</a></li>
                    <li><a href="#" class="crtaNav">Administracija</a></li>
                    <li><a href="unos.php" id="crtaNav">Unos</a></li>
                  </ul>
            </nav>
        </header>
        <section>
            <article class="flex-container1 crtaIznadArticla">
            <?php
               include "connect.php";

       
           
            if(isset($_POST['odjava'])){
                unset($_SERVER['$username']);
                unset($_SERVER['$level']);
                session_destroy();
                $location = "/Project Newsweek/administracija.php";
                header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location); 
            }

            if(isset($_POST["izbrisi"])){
                $id = $_POST['id'];
                $query = "DELETE FROM vijesti WHERE id = $id";
                $result = mysqli_query($dbc, $query) or die('Error querying database.'); 
            }
 
               if(isset($_POST['izmjeni'])){
                $id = $_POST['id'];
                $naslov=$_POST['naslov']; 
                $tekst=$_POST['tekst']; 
                $kategorija=$_POST['category']; 
                $slika = $_FILES['pphoto']['name'];
                if(isset($_POST['archive'])){ 
                    $arhiva=1; 
                }else{ 
                    $arhiva=0; 
                  } 
                $target_dir = 'img/'.$slika; 
                move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir); 
                if($slika != NULL){
                    $query = "UPDATE vijesti SET naslov='$naslov',tekst='$tekst',
                    slika='$slika',kategorija='$kategorija',arhiva='$arhiva'
                    WHERE id = $id";
                    $result = mysqli_query($dbc, $query) or die('Error querying database.');
                } else{
                    $query = "UPDATE vijesti SET naslov='$naslov',tekst='$tekst',
                    kategorija='$kategorija',arhiva='$arhiva'
                     WHERE id = $id";
                    $result = mysqli_query($dbc, $query) or die('Error querying database.');
                }
            }
               if(isset($_POST['login'])){
                  $istina = false;
                   
                  $korisnickoIme = $_POST['korisnickoIme'];
                  $lozinka = $_POST['sifra'];
                  $uspjesnaPrijava = False;
                  $sql = "SELECT korisnicko_ime,lozinka,razina FROM korisnik
                          WHERE korisnicko_ime = ?";
                  $stmt = mysqli_stmt_init($dbc);
                  if(mysqli_stmt_prepare($stmt,$sql)){
                      mysqli_stmt_bind_param($stmt, 's',$korisnickoIme);
                      mysqli_stmt_execute($stmt);
                      mysqli_stmt_store_result($stmt);
                  }
                  mysqli_stmt_bind_result($stmt, $korisnicko_ime, $lozinkaKorisnika, $razina); 
                  mysqli_stmt_fetch($stmt);
                  if(password_verify($_POST['sifra'],$lozinkaKorisnika) && mysqli_stmt_num_rows($stmt) > 0){
                      $uspjesnaPrijava = true;
                  } 
                  if($razina == 1) { 
                      $admin = true; 
                  } else { 
                      $admin = false; 
                  }
                  if($uspjesnaPrijava == True){
                    $_SESSION['$username'] = $korisnicko_ime; 
                    $_SESSION['$level'] = $razina;
                  } else {
                    echo "<span class='pogreska1'>Korisničko ime ili lozinka je krivo upisana</span>";
                  }
               } else {
                   $uspjesnaPrijava = false;
               }
               
               if (($uspjesnaPrijava == true && $admin == true) || 
               (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1){
                $istina = false;
                if($uspjesnaPrijava == true && $admin == true){
                    $istina = true;
                }
                $query = "SELECT * FROM vijesti ORDER BY datum DESC";
                $result = mysqli_query($dbc, $query); 
                
                while($row = mysqli_fetch_array($result)) { 
                    if($istina == true){
                        $location = "/Project Newsweek/administracija.php";
                        header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location); 
                        $istina = false;
                    }
                    echo "<form enctype='multipart/form-data' action='administracija.php' method='POST' class='forma1'>
                        <input type='hidden' name='id' class='form-field-textual' value='".$row['id']."'>
                        <div>
                            <label>Naslov članka</label>
                            <div>
                               <input type='text' name='naslov' class='naslovClanka' id='naslov' value='" . $row['naslov'] . "'>
                            </div>
                            <span id='porukaNaslova' class='pogreska'></span>

                        </div>
                        <div> 
                            <label for='content'>Sadržaj vijesti</label> 
                            <div> 
                               <textarea name='tekst' cols='30' rows'10'>" . $row['tekst'] ."</textarea>
                            </div> 
                        </div>
                        <div> 
                            <label for='pphoto'>Slika: </label> 
                            <div> 
                            <input class='odabirSlika' type='file' name='pphoto' value='".$row['slika']."'/> 
                            <div>
                            <img src='img/"  . $row['slika'] . "' width=100px>
                            </div>
                            </div> 
                        </div>
                        <div> 
                                <label for='category'>Kategorija vijesti</label>
                                <div> 
                                    <select name='category' value='".$row['kategorija']."'> ";
                                    if($row['kategorija'] == "U.S"){
                                       echo "<option value='U.S' selected>U.S</option> 
                                             <option value='World'>World</option>";
                                    } else{
                                    echo "<option value='U.S'>U.S</option> 
                                        <option value='World' selected>World</option>";
                                    }
                                    echo"</select>
                                </div> 
                        </div>
                        <div> 
                           <label>Spremiti u arhivu: </label>"; 
                           if($row['arhiva'] == 0) { 
                               echo "<input type='checkbox' name='archive' id='archive'/>"; 
                            } else { 
                                echo "<input type='checkbox' name='archive' id='archive' checked/>"; 
                    }
                    echo "</div>
                    <div>
                    <input type='hidden' name='id' value='".$row['id']."'>
                       <div>
                          <input type='reset' value='Poništi'/>
                       </div>
                       <div>
                          <input type='submit' name='izbrisi' value='Izbriši'/>
                       </div>
                       <div>
                          <input type='submit' name='izmjeni' id='izmjeni' value='Izmjeni'/>
                       </div>
                    </div>
                    </form>";
                }    
    
                
            } else if($uspjesnaPrijava == true && $admin == false){
                echo "<p> Dobrodošli," . $korisnicko_ime . ". Uspješno ste se prijavili, ali niste
                administrator";
                $location = "/Project Newsweek/administracija.php";
                header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location); 
                
            }else if(isset($_SESSION['$username']) && $_SESSION['$level'] == 0){
             echo "<p> Dobrodošli," . $_SESSION['$username'] . ". Uspješno ste se prijavili, ali niste
             administrator";
           

               
               } else if ($uspjesnaPrijava == false){
                   echo '<form class="forma1" action="" method="post">
                   <div>
                       <label>Korisničko Ime</label>
                       <div>
                           <input type="text" name="korisnickoIme" id="korisnickoIme" class="naslovClanka"/>
                       </div>
                       <span id="porukaKorisnickoIme" class="pogreska"></span>
                   </div>
                   <div>
                       <label>Šifra</label>
                       <div>
                           <input type="password" name="sifra" id="lozinka" class="naslovClanka"/>
                       </div>
                       <span id="porukaLozinka" class="pogreska"></span>
                   </div>  
                   <div>
                      <input type="submit" id="login" name="login" value="Login"/>
                   </div>
                   <div>
                      <a href="registracija.php">Registriraj se!</a>
                   </div>                   
              </form> ';
              
               }
            ?> 
        </article>
        <script type="text/javascript">
              document.getElementById("login").onclick = function(event){
                  var slanjeForme = true;

                  
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
               
                  if(lozinka.length > 0){
                    document.getElementById("porukaLozinka").innerHTML="";
                      okvirLozinke.style.border = "1px solid black";
                    
                  } else {
                    document.getElementById("porukaLozinka").innerHTML="Lozinka ili je prekratka ili lozinka nije ista ponovljenoj lozinci";
                      okvirLozinke.style.border = "1px dashed red";
                      slanjeForme = false;
                  }
                  if(slanjeForme != true){
                      event.preventDefault();
                  }
              };
           </script>
           <?php
           mysqli_close($dbc);
           ?>
        </section>
        <footer>
             <p id="copyright">@2021 Borna Mijić, bmijic@tvz.hr</p>
        </footer>
    </main>
</body>
</html>