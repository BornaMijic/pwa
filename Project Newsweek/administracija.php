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
                    <li><a href="#" id="crtaNav">Administracija</a></li>
                  </ul>
            </nav>
        </header>
        <section>
            <article class="flex-container1 crtaIznadArticla">
            <?php
               session_start();
               include "connect.php";
               if(isset($_POST['login'])){
                  $korisnickoIme = $_POST['korisnickoIme'];
                  $lozinka = $_POST['sifra'];
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
                  $_SESSION['$username'] = $korisnicko_ime; 
                  $_SESSION['$level'] = $razina;
               } else {
                   $uspjesnaPrijava = false;
               }
               
               if (($uspjesnaPrijava == true && $admin == true) || 
               (isset($_SESSION['$username'])) && $_SESSION['$level'] == 1){
                echo '<form method="post" action=""><input type="submit" name="odjava" value="odjava"/></form>';
                $query = "SELECT * FROM vijesti";
                $result = mysqli_query($dbc, $query); 
                while($row = mysqli_fetch_array($result)) { 
                    echo "<form enctype='multipart/form-data' action='administracija.php' method='POST' class='forma1'>
                        <input type='hidden' name='id' class='form-field-textual' value='".$row['id']."'>
                        <div>
                            <label>Naslov članka</label>
                            <div>
                               <input type='text' name='naslov' class='naslovClanka' value='" . $row['naslov'] . "'>
                            </div>
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
                          <input type='submit' name='izmjeni' value='Izmjeni'/>
                       </div>
                    </div>
                    </form>";
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
                mysqli_close($dbc);
            } else if($uspjesnaPrijava == true && $admin == false){
                echo "<p> Dobrodošli," . $imeKorisnika . ". Uspješno ste se prijavili, ali niste
                administrator";
            }else if(isset($_SESSION['$username']) && $_SESSION['$level'] == 0){
             echo "<p> Dobrodošli," . $_SESSION['$username'] . ". Uspješno ste se prijavili, ali niste
             administrator";
             echo '<form method="post" action=""><input type="submit" name="odjava" value="odjava"/></form>';

               
               } else if ($uspjesnaPrijava == false){
                   echo '<form class="forma1" action="" method="post">
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
                      <input type="submit" name="login" value="Login"/>
                   </div>
                   <div>
                      <a href="registracija.php">Registriraj se!</a>
                   </div>                   
              </form> ';
              
               }
            ?>
            <?php
           
            if(isset($_POST['odjava'])){
                unset($_SERVER['$username']);
                unset($_SERVER['$level']);
                session_destroy();
             
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