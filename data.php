<?php 

class Data {

    private $headers;
    private $content;
    private $code;

    public function __construct($headers, $content, $code) {
        $this->headers = $headers;
        $this->content = $content;
        $this->code = $code;
    }

    public function headers() {
        echo '<h2>Headers: </h2><p>'.$this->headers.'</p>';
    }
        
    public function content() {
        echo '<h2>Content: </h2><p>'.$this->content.'</p><hr/>';
    }
        
    public function code() {
        echo '<h2> Status code is: '.$this->code.'</h2><hr/>';
    }
}
?>