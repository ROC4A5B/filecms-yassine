<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    
    class filehandler{
        var  $filename; 
        var  $fileextention;
        var  $filesize;
        function __construct($naamvanfile) {
            $this->filename = $naamvanfile;
        }
        function createfile(){
         return $file = fopen("myfiles/".$this->filename, "w");
        }
        function readfile(){
     
           $file_content = file_get_contents("myfiles/".$this->filename);
           
           return $file_content;
        }
        function deletefile(){
            if (file_exists("myfiles/".$this->filename)) {
                 unlink("myfiles/".$this->filename);
                 echo "Het bestand: $this->filename is verwijderd ";
            } else {
                echo "Het bestand: $this->filename bestaat niet";
            }
        }
        function updatefile($bericht){
            $bericht + "\n";
            $file = fopen("myfiles/".$this->filename, "w") or die("File kan niet geopend worden");
            fwrite($file, $bericht);                   
            fclose($file);
        }
        function listfile(){
            $html = "";
            if ($handle = opendir('myfiles/.')) {
                   $html .= "<select name='file'>";
                    while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != "..") {
                          $html .= "<option value='$entry'>$entry</option>";
                        }
                    }
                 $html .= "</select>";
                    closedir($handle);
                }
            return $html;
        }
    }
function selectfile($namee, $naamfile){
    $htmloutput = "";
    $htmloutput .= "<form  method='post' class='select'>";
    $htmloutput .= "<input style='display:none;' type='text' name='copy' value='".$naamfile."'>";
    $htmloutput .= "<textarea name='inhoud'>".$namee->readfile()."</textarea><br>";
    $htmloutput .= "<input name='clicken' class='updatehet' type='submit' value='change'>&nbsp;";
    $htmloutput .= "<input name='delete' class='updatehet' type='submit' value='delete'>";
    $htmloutput .= "</form>";  
    
    return $htmloutput;
}
    if(isset($_POST['clicken'])){
        switch ($_POST['clicken']) {
            case 'tonen':
               $htmloutput = "";
               $filename =  $_POST['file'];
               $filenaam = new filehandler($filename);
               $htmloutput = selectfile($filenaam, $filename);    
               echo $htmloutput; 
            break;
            case 'change':
                $inhoud = $_POST['inhoud'];
                $filename = $_POST['copy'];
                $filenaam = new filehandler($filename);
                $filenaam->updatefile($inhoud);
            break;
            case 'new file':
                  $filename = $_POST['newfile'];
                  $filenaam = new filehandler($filename);
                  $filenaam->createfile();
                  echo "refresh";
            break;
        }
     }
         if(isset($_POST['delete'])){
            $filename = $_POST['copy'];
            $filenaam = new filehandler($filename);
            $filenaam->deletefile();
         }  
         if(isset($_POST['run'])){
            $string = $_POST['morefiles'];
            $filearrays = explode(',', $string); 
            foreach($filearrays as $file_name){
                file_put_contents("myfiles/".$file_name, "");
            }
            echo 'refresh';
         }
