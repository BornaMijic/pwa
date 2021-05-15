<?php
                     include 'connect.php'; 
                      $title=$_POST['naslov']; 
                      $content=$_POST['content']; 
                      $category=$_POST['category']; 
                      $date=date('d.m.Y.'); 
                      $picture = $_FILES['pphoto']['name'];
                      if(isset($_POST['archive'])){ 
                          $archive=1; 
                      }else{ 
                          $archive=0; 
                        } 
                        $target_dir = 'img/'.$picture; 
                        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir); 
                        $query = "INSERT INTO vijesti (datum, naslov, tekst, slika, kategorija, arhiva ) VALUES ('$date', '$title', '$content', '$picture', '$category', '$archive')"; 
                        $result = mysqli_query($dbc, $query) or die('Error querying database.'); 
?> 