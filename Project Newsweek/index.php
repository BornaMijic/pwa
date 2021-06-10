
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
                    <li><a href="#" class="crtaNav" >Home</a></li>
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
            <article class="crtaIznadArticla">
               <p class="naslovKategorija">U.S.</p>
      
                      <?php include 'connect.php'; 
                      $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='U.S' ORDER BY datum DESC LIMIT 3"; 
                      $result = mysqli_query($dbc, $query); 
                      $i=0; 
                      while($row = mysqli_fetch_array($result)) { 
                        if($i == 2){
                            echo '<div class="floatovi"> ';
                            echo '<a class="link" href="clanak.php?id='.$row['id'].'">'; 
                            echo '<img class="image" src="img/'.$row['slika'] . '"'; 
                            echo '<div>'; 
                            echo '<h4 class="nasloviclanaka1">'; 
                            echo $row['naslov']; echo '</h4>'; 
                            echo '</div></a>';
                            echo '</div>';
                            $i++;
                        } else {        
                            echo '<div class="floatovi razmakIzmeduSlika"> ';
                            echo '<a class="link" href="clanak.php?id='.$row['id'].'">'; 
                            echo '<img class="image" src="img/'.$row['slika'] . '"'; 
                            echo '<div>'; 
                            echo '<h4 class="nasloviclanaka1">'; 
                            echo $row['naslov']; echo '</h4>'; 
                            echo '</div></a>';
                            echo '</div>';
                            $i++;
                        }
                      }
                      ?> 
            </article>
            <article class="crtaIznadArticla clear">
                <p class="naslovKategorija">World</p>
                <?php include 'connect.php'; 
                      $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='World' ORDER BY datum DESC LIMIT 3"; 
                      $result = mysqli_query($dbc, $query); 
                      $i=0; 
                      while($row = mysqli_fetch_array($result)) { 
                        if($i == 2){
                            echo '<div class="floatovi"> ';
                            echo '<a class="link" href="clanak.php?id='.$row['id'].'">'; 
                            echo '<img class="image" src="img/'.$row['slika'] . '"'; 
                            echo '<div>'; 
                            echo '<h4 class="nasloviclanaka1">'; 
                            echo $row['naslov']; echo '</h4>'; 
                            echo '</div></a>';
                            echo '</div>';
                            $i++;
                        } else {        
                            echo '<div class="floatovi razmakIzmeduSlika"> ';
                            echo '<a class="link" href="clanak.php?id='.$row['id'].'">'; 
                            echo '<img class="image" src="img/'.$row['slika'] . '"'; 
                            echo '<div>'; 
                            echo '<h4 class="nasloviclanaka1">'; 
                            echo $row['naslov']; echo '</h4>'; 
                            echo '</div></a>';
                            echo '</div>';
                            $i++;
                        }
                      }
                      mysqli_close($dbc);  
                      ?> 
                      <?php
           
           if(isset($_POST['odjava'])){
               unset($_SERVER['$username']);
               unset($_SERVER['$level']);
               session_destroy();
               $location = "/Project Newsweek/index.php";
               header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
               
           }
        ?>  
            </article>
        </section>
        <footer class="clear">
             <p id="copyright">@2021 Borna Mijić, bmijic@tvz.hr</p>
        </footer>
    </main>
</body>
</html>