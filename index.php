<?php
/*
*   xr.com - Unreliable. Goes down a lot.
*   xrl.us - Marked as spam on Twitter
*   fong.us - Manually approves links.
*/
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

    public function alturl_com($url='http://brandonkprobst.com')
    {
        $alturl_com = file_get_contents('http://shorturl.com/make_url.php?longurl='.$url);

        if(preg_match_all("/(\[)(<)(a)( )(href)(=)((?:http|https)(?::\/{2}[\w]+)(?:[\/|\.]?)(?:[^\s\"]*))/is", $alturl_com, $matches))
        {
            $this->short_urls[] = $matches[7][0];
        }        
    }


    public function to_ly($url='http://brandonkprobst.com')
    {
        $to_ly = file_get_contents('http://to.ly/api.php?longurl='.$url);

        $this->short_urls[] = $to_ly;
    }

    public function url_ie($url='http://brandonkprobst.com')
    {
        $url_ie = file_get_contents('http://url.ie/site/api/tinyurl/create/?url='.$url);

        $this->short_urls[] = $url_ie;
    }

    public function moourl_com($url='http://brandonkprobst.com')
    {
        $moourl_com = file_get_contents('http://moourl.com/create/?source='.$url);

        if (preg_match_all("/(<div id=\"milked_url\" style=\"display:none;\">)((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s\"]*))/is", $moourl_com, $matches))
        {
            $this->short_urls[] = $matches[2][0];
        }
    }

    public function snipr_com($url='http://brandonkprobst.com')
    {
        $snipr_com = file_get_contents('http://snipr.com/site/snip?link='.$url);

        if(preg_match_all("/(<)(div)( )(class)(=)(\"cbutton\")( )(val)(=)(\")((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s\"]*))/is", $snipr_com, $matches))
        {
            $this->short_urls[] = $matches[11][0];
        }        
    }

    public function ze_tl($url='http://brandonkprobst.com')
    {
        $ze_tl = file_get_contents('http://ze.tl/?url='.$url);
        $ze_tl = json_decode($ze_tl);

        $this->short_urls[] = $ze_tl->url;
    }

    public function tinyy_me($url='http://brandonkprobst.com')
    {
        $tinyy_me = file_get_contents('http://tinyy.me/api.php?url='.$url);

        $this->short_urls[] = $tinyy_me;
    }

    public function shrinkr_me($url='http://brandonkprobst.com')
    {
        $shrinkr_me = file_get_contents('http://shrinkr.me/api.php?url='.$url);

        $this->short_urls[] = $shrinkr_me;
    }

    public function lnk_in($url='http://brandonkprobst.com')
    {
        $lnk_in = file_get_contents('http://lnk.in/remote.php?url='.$url);

        if(preg_match_all("/(id)(=)(\"divMessageBox\")(>).*?((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s\"]*))/is", $lnk_in, $matches))
        {
            $this->short_urls[] = $matches[5][0];
        }
    }

    public function bit_ly($url='http://brandonkprobst.com')
    {
        $bit_ly = file_get_contents('http://api.bit.ly/shorten?version=2.0.1&longUrl='.$url.'&login=d0pus&apiKey=R_1b7ef98c4c59295606a0efe1a0bb217c&format=json');
        $bit_ly = json_decode($bit_ly,true);
        $this->short_urls[] = $bit_ly['results'][$url]['shortUrl'];
    }

    public function main()
    {
        if(count($_POST)<1)
        {
            return $this->show_form = TRUE;
        }
        else
        {
            $long_url = $_POST['uri'];

            $this->tiny_cc($long_url);
            $this->is_gd($long_url);
            $this->alturl_com($long_url);
            $this->to_ly($long_url);
            $this->url_ie($long_url);
            $this->moourl_com($long_url);
            $this->snipr_com($long_url);
            $this->ze_tl($long_url);
            $this->tinyy_me($long_url);
            $this->shrinkr_me($longurl);
            $this->lnk_in($longurl);
            $this->bit_ly($longurl);

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
            foreach($multishort->short_urls as $short_url):
                echo $short_url.'<br />';
            endforeach;
      endif;
?>