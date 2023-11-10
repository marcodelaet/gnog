<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
Class SendMail{
    private $sender_name;
    private $sender_email;
    private $to_name;
    private $to_email;
    private $subject;
    private $body_text;
    private $fileName;
    private $fileType;
    private $attached_file = '';
    private $signature_file = '';
    private $boundary;
    private $headers;
    private $messageHTML;

    public function setSenderName($string){
        $this->sender_name = $string;
    }

    public function setSenderEmail($string){
        $this->sender_email = $string;
    }

    public function setToName($string){
        $this->to_name = $string;
    }

    public function setToEmail($string){
        $this->to_email = $string;
    }

    public function setSubject($string){
        $this->subject = $string;
    }

    public function setBodyText($text){
        $this->body_text = "
        <html>
        <head>
          <title>$this->subject</title>
          <style amp-custom>            
            .download-pdf-file{
                  display: flex;
                  vertical-align: middle;
                  font-size: 0.7rem;
            }
          </style>        
        </head>
        <body>
            <div class='messageText'>
                <p>$text</p>
            </div>
            <div class='signature'>
                <img src='$this->signature_file' />
            </div>
        </body>
        </html>
        ";
    }

    public function setBoundary($module){
        $this->boundary = "GNOG-".md5(date("dmYis"))."-".strtoupper($module);
    }

    public function setFileName($filePath){
        $this->signature_file = "https://providers.gnogmedia.com/assets/img/$filePath";
    }

    public function setFile($filePath){
        $path = $filePath;
        $this->fileType = mime_content_type( $path );
        $this->fileName = basename( $path );

        // creating the attached file
        $fp = fopen( $path, "rb" ); // open file
        $attached_file_local = fread( $fp, filesize( $path ) ); // Calculating file size
        $this->attached_file = chunk_split(base64_encode( $attached_file_local )); // encoding file in 64 Bits
        fclose( $fp ); // Close file
    }

    public function setHeaders(){
        $headersLocal = 'MIME-Version: 1.0' . "\r\n";
        $headersLocal .= 'Content-Type: multipart/mixed;' . "\r\n";
        $headersLocal .= "From: $this->sender_name <$this->sender_email>" . "\r\n";
        $headersLocal .= "Reply-To: $this->sender_name <$this->sender_email>" . "\r\n";
        $headersLocal .= "boundary:" . $this->boundary . "\r\n";    
        $this->headers = $headersLocal;
    }



    public function setMessage($bodyHTML){
        $this->setBodyText($bodyHTML);
        $messageLocalHTML  = "--$this->boundary" . PHP_EOL;
        $messageLocalHTML .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        //$messageLocalHTML .= "Content-Type: text/html; charset='utf-8'" . PHP_EOL;
        $messageLocalHTML .= $this->body_text; // Add here message to send
        $this->messageHTML = $messageLocalHTML . "--$this->boundary" . PHP_EOL;
    }

    public function addAttachedFile($filePath){
        $this->setFile($filePath);
        $this->setHeaders();
        $messageLocalHTML = '';
        if($this->messageHTML != ''){
            $messageLocalHTML = $this->messageHTML;
        }
        $messageLocalHTML = "Content-Type: ". $this->fileType ."; name=\"". $this->fileName . "\"" . PHP_EOL;
        $messageLocalHTML .= "Content-Transfer-Encoding: base64" . PHP_EOL;
        $messageLocalHTML .= "Content-Disposition: attachment; filename=\"". $this->fileName . "\"" . PHP_EOL;
        $messageLocalHTML .= "$this->attached_file" . PHP_EOL;
        $this->messageHTML = $messageLocalHTML  . "--$this->boundary" . PHP_EOL;
    }

    public function sendGNogMail($from_name,$from_email,$to_name,$to_email,$subject,$messageHtml,$signFilePath,$attachedFiles){
        $this->setSenderName($from_name);
        $this->setSenderEmail($from_email);
        $this->setToName($to_name);
        $this->setToEmail($to_email);
        $this->setSubject($subject);
        $this->setBoundary('providers');
        $this->setHeaders();
        $this->setFileName($signFilePath);
        if($attachedFiles !== ""){
            $aFiles = explode(";",$attachedFiles);
            for($i=0;$i<count($aFiles);$i++){
                $this->addAttachedFile($aFiles[$i]);
            }
        }
        //$this->addAttachedFile($signFilePath);
        $this->setMessage($messageHtml);

        $aNames = explode(",",$this->to_name);
        $aMails = explode(",",$this->to_email);
        $to = '';
        for($i=0;$i<count($aNames);$i++){
            if($i>0)
                $to .= ", ";
            $to .= $aNames[$i] . "<".$aMails[$i].">";
        }
        
        $sent = mail($to, $this->subject, $this->messageHTML, $this->headers);
        return $sent;
    }

}
?>