<?php

class Multishort
{
    /*
    * Boolean; Decides whether or not a form should be shown
    */
    public $show_form;

    /*
    * String; Set when form is posted from
    */
    public $long_url;

    /*
    * Array; An array of all the short URLs generated
    */
    public $short_urls;

    public function __construct()
    {
        $this->main();
    }

    /*
    * Function names are formatted like so:
    * domain_tld
    * Maintain this.
    */
    public function bit_ly(){}

    public function tiny_cc($url='http://brandonkprobst.com')
    {
        $tiny_cc   = 'http://tiny.cc/?c=rest_api&m=shorten&version=2.0.3&format=json&longUrl='.$url.'&login=d0pus&apiKey=8e1c9918-1e08-48ea-a228-bb02e15050e5';
        $response  = file_get_contents($tiny_cc);
        $json      = @json_decode($response,true);

        $this->short_urls[] = $json['results']['short_url'];
    }

    public function is_gd($url='http://brandonkprobst.com')
    {
        $is_gd = file_get_contents('http://is.gd/create.php?format=simple&url='.$url);

        $this->short_urls[] = $is_gd;
    }

    public function su_pr(){}

    public function xrl_us($url='http://brandonkprobst.com')
    {
        $xrl_us = file_get_contents('http://metamark.net/api/rest/simple?long_url='.$url);
        
        $this->short_urls[] = $xrl_us;
    }

    public function alturl_com($url='http://brandonkprobst.com')
    {
        $alturl_com = file_get_contents('http://shorturl.com/make_url.php?longurl='.$url);

        if(preg_match_all("/(\[)(<)(a)( )(href)(=)((?:http|https)(?::\/{2}[\w]+)(?:[\/|\.]?)(?:[^\s\"]*))/is", $alturl_com, $matches))
        {
            $this->short_urls[] = $matches[7][0];
        }        
    }

    public function xr_com($url='http://brandonkprobst.com')
    {
        $xr_com = file_get_contents('http://xr.com/index.php?action=shortenurl&customize=0&createit=1&link='.$url);

        if(preg_match_all("/()(<)(A)( )(HREF)(=)(\")((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s\"]*))/is", $xr_com, $matches))
        {
            $this->short_urls[] = $matches[8][0];
        }        
    }

    public function yep_it(){}

    public function to_ly(){}

    public function fong_us(){}

    public function url_ie(){}

    public function moourl_com(){}

    public function main()
    {
        if(count($_POST) < 1)
        {
            return $this->show_form = TRUE;
        }
        else
        {
            //$this->tiny_cc();
            //$this->is_gd();
            //$this->xrl_us();
            //$this->alturl_com();
            //$this->xr_com();
            return $this->show_form = FALSE;
        }
    }
}

$multishort = new Multishort();
?>

<?php if($multishort->show_form == TRUE):?>
    <form action="" method="post">
        <div>
            <input type="text" name="uri" placeholder="Enter URL here" /> <input type="submit" name="submit" value="Shorten" />
        </div>
    </form>
<?php elseif($multishort->show_form == FALSE):
            echo "SHOW URLS";
      endif;
?>

