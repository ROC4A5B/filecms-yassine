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
           if(filesize($this->filename) == false){
              $this->updatefile("File = Empty");
              $this->filesize = filesize($this->filename);
              $file = fopen($this->filename, "r") or die("Niet mogelijk om het bestand te openen"); 
              return fread($file,$this->filesize);
           }else{
              $this->filesize = filesize($this->filename);
              $file = fopen($this->filename, "r") or die("Niet mogelijk om het bestand te openen"); 
              return fread($file,$this->filesize);
           }
        }
        function deletefile(){
            if (file_exists($this->filename)) {
                 unlink($this->filename);
                 echo "Het bestand: $this->filename is verwijderd ";
            } else {
                echo "Het bestand: $this->filename bestaat niet";
            }
        }
        function updatefile($bericht){
            $bericht + "\n";
            $file = fopen($this->filename, "w") or die("File kan niet geopend worden");
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
            $html .= "<input class='kiesjefile' type='submit' value='tonen'>";
            return $html;
        }
    }
function selectfile($namee, $naamfile){
    $htmloutput = "";
    $htmloutput .= "<form  method='post' class='select'>";
    $htmloutput .= "<input style='display:none;' type='text' name='copy' value='".$naamfile."'>";
    $htmloutput .= "<textarea name='inhoud'>".$namee->readfile()."</textarea><br>";
    $htmloutput .= "<input class='updatehet' type='submit' value='Change'>";
    $htmloutput .= "</form>";  
    
    return $htmloutput;
}
    
    if(isset($_POST)){
        if (isset($_POST['file'])) {
            $htmloutput = "";
            $filename =  $_POST['file'];
            $filenaam = new filehandler($_POST['file']);
            $htmloutput = selectfile($filenaam, $filename);    
            echo $htmloutput;
        }
        
        if (isset($_POST['copy'])) {
            $inhoud = $_POST['inhoud'];
            $filename = $_POST['copy'];
            $filenaam = new filehandler($filename);
            $filenaam->updatefile($inhoud);

        }
     }