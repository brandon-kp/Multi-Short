<?php

if(isset($_GET['uri']))
{
	$getURL = $_GET['uri'];
	
	function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
	{
	  $bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.$url.'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
	  $response = file_get_contents($bitly);
	  if(strtolower($format) == 'json')
	  {
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	  }
	  else
	  {
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	  }
	}

	function make_tiny_url($url)
	{
		$tinyurl = 'http://tinyurl.com/create.php?url='.$url;
		$source = file_get_contents($tinyurl);
		
	}

	function make_tinycc_url($url, $login, $appkey)
	{
		$tinycc = 'http://tiny.cc/?c=rest_api&m=shorten&version=2.0.2&format=json&longUrl='.$url.'&login='.$login.'&apiKey='.$appkey;
		$response = file_get_contents($tinycc);
		$json = @json_decode($response,true);
		return $json['results']['short_url'];
	}

	function make_isgd_url($url)
	{
		$is_gd = file_get_contents('http://is.gd/create.php?format=simple&url='.$url);
		return $is_gd;
	}

	function make_supr_url($url, $login, $appkey)
	{
		$supr = 'http://su.pr/api/simpleshorten?url='.$url.'&login='.$login.'&apiKey='.$appkey;;
		return file_get_contents($supr);
	}
	
	function make_xrlus_url($url)
	{
		$xrlus= file_get_contents('http://metamark.net/api/rest/simple?long_url='.$url);
		return $xrlus;
	}
	
	function make_alturl_url($url)
	{
		$txt=file_get_contents('http://shorturl.com/make_url.php?longurl='.$url);
		$re1='(\\[)';
		$re2='(<)';
		$re3='(a)';
		$re4='( )';
		$re5='(href)';
		$re6='(=)';
		$re7='((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))';

		if ($c=preg_match_all ("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7."/is", $txt, $matches))
		{
			$c1=$matches[1][0];
			$c2=$matches[2][0];
			$var1=$matches[3][0];
			$ws1=$matches[4][0];
			$word1=$matches[5][0];
			$c3=$matches[6][0];
			$httpurl1=$matches[7][0];
			return $httpurl1;
		}
	}

	function make_xr_url($url)
	{
		$txt=file_get_contents('http://xr.com/index.php?action=shortenurl&customize=0&createit=1&link='.$url);

		$re1='()';
		$re2='(<)';
		$re3='(A)';
		$re4='( )';
		$re5='(HREF)';	
		$re6='(=)';
		$re7='(")';
		$re8='((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))';

		if ($c=preg_match_all ("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7.$re8."/is", $txt, $matches))
		{
		$tag1=$matches[1][0];
		$c1=$matches[2][0];
		$var1=$matches[3][0];
		$ws1=$matches[4][0];
		$word1=$matches[5][0];
		$c2=$matches[6][0];
		$c3=$matches[7][0];
		$httpurl1=$matches[8][0];
		return $httpurl1;
		}
	}
	
	function make_yep_url($url)
	{
		$yep = file_get_contents('http://yep.it/api.php?url='.$url);
		$yep = str_replace("\r",'',$yep);
		return $yep;
	}
	
	function make_toly_url($url)
	{
		$toly = file_get_contents('http://to.ly/api.php?longurl='.$url);
		return $toly;
	}
	
	function make_fongs_url($url)
	{
		$fongs = file_get_contents('http://fon.gs/create.php?url='.$url);
		$replace = array('OK:','MODIFIED:','AVAILABLE','TAKEN:');
		$fongs = str_replace($replace,'',$fongs);
		return $fongs;
	}
	
	function make_urlie_url($url)
	{
		$txt = file_get_contents('http://url.ie/site/create/?ver=2&s=W&url='.$url);
		$re1='(value)';
		$re2='(=)';
		$re3='(")';
		$re4='((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))';

		if ($c=preg_match_all ("/".$re1.$re2.$re3.$re4."/is", $txt, $matches))
		{
			$httpurl1=$matches[4][0];
			return $httpurl1;
		}
	}

	function make_moo_url($url)
	{
		$txt=file_get_contents('http://moourl.com/create/?source='.$url);

		$re1='(<div id="milked_url" style="display:none;">)';	# Tag 1
		$re2='((?:http|https)(?::\\/{2}[\\w]+)(?:[\\/|\\.]?)(?:[^\\s"]*))';	# HTTP URL 1

		if ($c=preg_match_all ("/".$re1.$re2."/is", $txt, $matches))
		{
			$tag1=$matches[1][0];
			$httpurl1=$matches[2][0];
			return $httpurl1;
		}
	}
	
	$bitly = make_bitly_url($getURL,'d0pus','R_1b7ef98c4c59295606a0efe1a0bb217c','json');
	$tinycc = make_tinycc_url($getURL, 'd0pus', '8e1c9918-1e08-48ea-a228-bb02e15050e5');
	$isgd = make_isgd_url($getURL);
	$supr = make_supr_url($getURL,'SevenBeasts','1de3b46f540820244357dddcd89d5966');
	$xrlus = make_xrlus_url($getURL);
	$alturl = make_alturl_url($getURL);
	//$snipurl = make_snip_url($getURL, 'd0pus', 'O');
	$xr = make_xr_url($getURL);
	$yep = make_yep_url($getURL);
	$toly = make_toly_url($getURL);
	$fongs = make_fongs_url($getURL);
	$urlie = make_urlie_url($getURL);
	$moo = make_moo_url($getURL);
	
	echo "<div>";
	echo 'Bit.ly::.  '.$bitly.' <br />';
	echo 'Tiny.cc::. '.$tinycc.' <br />';
	echo 'Is.gd::. '.$isgd.' <br />';
	echo 'Su.pr::. '.$supr.' <br />';
	echo 'Xrl.us::. '.$xrlus.' <br />';
	echo 'Alturl.com::. '.$alturl.' <br />';
	echo 'Xr.com::. '.$xr.' <br />';
	echo 'Yep.it::. '.$yep.' <br />';
	echo 'To.ly::. '.$toly.' <br />';
	echo 'Fong.us::. '.$fongs.' <br />';
	echo 'Url.ie::. '.$urlie.' <br />';
	echo 'Moourl.com::. '.$moo.' <br />';
	echo "</div>";
	
}