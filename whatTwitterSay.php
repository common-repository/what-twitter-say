<?php
/*
Plugin Name: what twitter say
Plugin URI: http://aan.dudut.com
Description: find out what twitter say about a certain keyword and put it on your sidebar.
Version: 1.0.1
Author: aankun
Author URI: http://aan.dudut.com/
*/

//activate and deactivate ==========================================================================================
register_activation_hook( __FILE__, 'what_twitter_say_activate' );
function what_twitter_say_activate(){
	$myOptions = array(
		"keyOne"       => 'aankun',
		"optionalKey"  => '',
		"pCount"       => 10,
		"widget_title" => 'what Twitter Say!',
		"nd_title"     => 'just my Tweet!',
		"username"     => 'aankun',
		"myTweetN"     => 10,
		"style_width"  => 32,
		"useDefaCss"   => true
	);

	add_option("what_twitter_say_options", $myOptions, '', 'yes');
}

register_deactivation_hook( __FILE__, 'what_twitter_say_deactivate' );
function what_twitter_say_deactivate() {
	delete_option("what_twitter_say_options");
}
//siebar thing =====================================================================================================
function widget_what_twitter_say_init() {
	if (!function_exists('register_sidebar_widget')) {
		return;
	}
	
	function widget_what_twitter_say($args){
	    extract($args);
		$myOptions   = get_option('what_twitter_say_options');
		$title       = $myOptions['widget_title'];
		$keyOne      = $myOptions['keyOne'];
		$optionalKey = $myOptions['optionalKey'];
		$pCount      = $myOptions['pCount'];
	?>
		<?php echo $before_widget; ?>
			<?php echo $before_title
                . $title
                . $after_title; ?>
				<ul id="wholeTweets">
		            <?php twitterSay($keyOne , $optionalKey, $pCount); ?>
				</ul>
		<?php echo $after_widget; ?>
	<?php
	}
	register_sidebar_widget('whatTwitterSay', 'widget_what_twitter_say');
	
	
	function widget_what_twitter_say_control() {
		$myOptions   = get_option('what_twitter_say_options');
		$title       = $myOptions['widget_title'];
		$keyOne      = $myOptions['keyOne'];
		$optionalKey = $myOptions['optionalKey'];
		$pCount      = $myOptions['pCount'];
		$useDefaCss  = $myOptions['useDefaCss'];
		
		if ('process' == $_POST['stage_what_twitter_say']) {
		if (!empty($_POST['what_twitter_say_title'])) {
			$title = strip_tags(stripslashes($_POST['what_twitter_say_title']));
			$myOptions['widget_title'] = $title;
			update_option('what_twitter_say_options', $myOptions);
		}
		
		$keyOne = strip_tags(stripslashes($_POST['what_twitter_say_key']));
		$myOptions['keyOne'] = $keyOne;
		update_option('what_twitter_say_options', $myOptions);
		$optionalKey = strip_tags(stripslashes($_POST['what_twitter_say_key_opt']));
		$myOptions['optionalKey'] = $optionalKey;
		update_option('what_twitter_say_options', $myOptions);
				
		if (!empty($_POST['what_twitter_say_p_count'])) {
			$pCount = strip_tags(stripslashes($_POST['what_twitter_say_p_count']));
			$myOptions['pCount'] = $pCount;
			update_option('what_twitter_say_options', $myOptions);
		}
		
		$useDefaCss = $_POST['what_twitter_say_use_defa_css'];
		$myOptions['useDefaCss'] = $useDefaCss;
		update_option('what_twitter_say_options', $myOptions);
		}
		
		$title = htmlspecialchars($title, ENT_QUOTES);
		$keyOne = htmlspecialchars($keyOne, ENT_QUOTES);
		$optionalKey = htmlspecialchars($optionalKey, ENT_QUOTES);
		?>
			<p>
				<input type="hidden" name="stage_what_twitter_say" value="process" />
				<label for="what_twitter_say_widget_title">
					Title<br />
					<input type="text" style="width:99%;" id="what_twitter_say_title" name="what_twitter_say_title" value="<?php echo $title; ?>" />
				</label><br />
                <label for="what_twitter_say_key">
					All of these words
					<input type="text" style="width:99%;" id="what_twitter_say_key" name="what_twitter_say_key" value="<?php echo $keyOne; ?>" />
				</label><br />
                <label for="what_twitter_say_key_opt">
					Any of these words
					<input type="text" style="width:99%;" id="what_twitter_say_key_opt" name="what_twitter_say_key_opt" value="<?php echo $optionalKey; ?>" />
				</label><br />
                <label for="what_twitter_say_p_count">
					Number of tweets
					<input type="text" style="width:99%;" id="what_twitter_say_p_count" name="what_twitter_say_p_count" value="<?php echo $pCount; ?>" />
				</label>
				<label for="use_defa_css">
					Use Default Css?
					<?php
                    if($useDefaCss) {
                        echo("\n<input id=\"what_twitter_say_use_defa_css\" type=\"checkbox\" name=\"what_twitter_say_use_defa_css\" value=\"1\" checked=\"checked\" />\n");
                    } else {
                        echo("\n<input id=\"what_twitter_say_use_defa_css\" type=\"checkbox\" name=\"what_twitter_say_use_defa_css\" value=\"1\" />\n");
                    }
                    ?>
				</label>
			</p>
			
		<?php
		
	}
	register_widget_control('whatTwitterSay', 'widget_what_twitter_say_control', 200, 50);
	
	function just_my_tweet($args){
	    extract($args);
		$myOptions   = get_option('what_twitter_say_options');
		$title       = $myOptions['nd_title'];
		$tUsername   = $myOptions['username'];
		$myTweetN    = $myOptions['myTweetN'];
	?>
		<?php echo $before_widget; ?>
			<?php echo $before_title
                . $title
                . $after_title; ?>
				<ul id="justMyTweet">
		            <?php justSayMyTweet($tUsername,$myTweetN); ?>
				</ul>
		<?php echo $after_widget; ?>
	<?php
	}
	register_sidebar_widget('justMyTweet', 'just_my_tweet');
	
	
	function just_say_my_tweet_control() {
		$myOptions   = get_option('what_twitter_say_options');
		$title       = $myOptions['nd_title'];
		$tUsername   = $myOptions['username'];
		$myTweetN    = $myOptions['myTweetN'];
		$useDefaCss  = $myOptions['useDefaCss'];
		
		if ('process' == $_POST['stage_just_my_twitter']) {
		if (!empty($_POST['just_say_my_tweet_title'])) {
			$title = strip_tags(stripslashes($_POST['just_say_my_tweet_title']));
			$myOptions['nd_title'] = $title;
			update_option('what_twitter_say_options', $myOptions);
		}
		if (!empty($_POST['just_say_my_tweet_username'])) {
			$tUsername = strip_tags(stripslashes($_POST['just_say_my_tweet_username']));
			$myOptions['username'] = $tUsername;
			update_option('what_twitter_say_options', $myOptions);
		}
		if (!empty($_POST['my_tweet_n'])) {
			$myTweetN = strip_tags(stripslashes($_POST['my_tweet_n']));
			$myOptions['myTweetN'] = $myTweetN;
			update_option('what_twitter_say_options', $myOptions);
		}
		$useDefaCss = $_POST['what_twitter_say_use_defa_css2'];
		$myOptions['useDefaCss'] = $useDefaCss;
		update_option('what_twitter_say_options', $myOptions);
		}
		
		$title = htmlspecialchars($title, ENT_QUOTES);
		$username = htmlspecialchars($username, ENT_QUOTES);
		?>
			<input type="hidden" name="stage_just_my_twitter" value="process" />
			<p>
				<label for="just_say_my_tweet_widget_title">
					Title<br />
					<input type="text" style="width:99%;" id="just_say_my_tweet_title" name="just_say_my_tweet_title" value="<?php echo $title; ?>" />
				</label><br />
                <label for="just_say_my_tweet_username">
					Username
					<input type="text" style="width:99%;" id="just_say_my_tweet_username" name="just_say_my_tweet_username" value="<?php echo $tUsername; ?>" />
				</label><br />
                <label for="my_tweet_n">
					Number of tweets
					<input type="text" style="width:99%;" id="my_tweet_n" name="my_tweet_n" value="<?php echo $myTweetN; ?>" />
				</label>
				<label for="use_defa_css">
					Use Default Css?
					<?php
                    if($useDefaCss) {
                        echo("\n<input id=\"what_twitter_say_use_defa_css2\" type=\"checkbox\" name=\"what_twitter_say_use_defa_css2\" value=\"1\" checked=\"checked\" />\n");
                    } else {
                        echo("\n<input id=\"what_twitter_say_use_defa_css2\" type=\"checkbox\" name=\"what_twitter_say_use_defa_css2\" value=\"1\" />\n");
                    }
                    ?>
				</label>
			</p>
			
		<?php
		
	}
	register_widget_control('justMyTweet', 'just_say_my_tweet_control', 200, 50);
}
add_action('widgets_init', 'widget_what_twitter_say_init');
//=====================================================================================================
function twitterSay($keyOne,$optionalKey,$count){
	//echo $keyOne;
	$twitterSay = new whatTwitterSay($keyOne,$optionalKey,$count,'','');
	$twitterSay->display();
}

function justSayMyTweet($username,$myTweetN){
	//echo $username.'  |  '.$myTweetN;
	$myTweet = new whatTwitterSay('','','',$username,$myTweetN);
	$myTweet->myTweet();
}

class whatTwitterSay {
	private $keyOne;
	private $optionalKey;
	private $count;
	private $username;
	private $myTweetN;
	
	var $error;
	
	function __construct($keyOne,$optionalKey,$count,$username,$myTweetN){
		$this->keyOne      = trim($keyOne);
		$this->optionalKey = trim($optionalKey);
		$this->pCount      = $count;
		$this->username    = trim($username);
		$this->myTweetN    = $myTweetN;
	}
	
	function myTweet(){
		$output = '';
		$url = 'http://search.twitter.com/search.atom?from='.$this->username.'&rpp='.$this->myTweetN;
		$says = self::getXml($url);
		if(!empty($says)){
		foreach ($says->entry as $entry) {
			$auth     = explode('(',$entry->author->name);
			$nameOnly = trim($auth[0]);
			$thaTime  = explode('T',str_replace('Z','',$entry->published));
			//$aa = str_replace(,
			
			$output .= '<li>';
				//$output .= '<div class="tweetAvatar"><img src="'.$entry->link[1]['href'].'"></div>';
				$output .= '<p class="tweetContent">'.$entry->content.'</p>';
				$output .= '<p class="tweetInfo"><a class="tweetTime" href="'.$entry->link[0]['href'].'">'.$thaTime[0].' '.$thaTime[1].'</a></p>';
			$output .= '</li>';
		}}
		echo $output;
	}
	
	function display(){ 
		$output = '';
		
		if(!empty($this->optionalKey)){
			$url ='http://search.twitter.com/search.atom?ands='.str_replace(' ','+',$this->keyOne).'&ors='.str_replace(' ','+',$this->optionalKey).'&rpp='.$this->pCount;
		}else{
			$url = 'http://search.twitter.com/search.atom?q='.str_replace(' ','+',$this->keyOne).'&rpp='.$this->pCount;
		}
		
		$says = self::getXml($url);
		if(!empty($says)){
		foreach ($says->entry as $entry) {
			$auth     = explode('(',$entry->author->name);
			$nameOnly = trim($auth[0]);
			$thaTime  = explode('T',str_replace('Z','',$entry->published));
			//$aa = str_replace(,
			
			$output .= '<li>';
				$output .= '<div class="tweetAvatar"><img src="'.$entry->link[1]['href'].'"></div>';
				$output .= '<p class="tweetContent">'.$entry->content.'</p>';
				$output .= '<p class="tweetInfo"><a class="tweetUser" href="'.$entry->author->uri.'">'.$nameOnly.'</a> <a class="tweetTime" href="'.$entry->link[0]['href'].'">'.$thaTime[0].' '.$thaTime[1].'</a></p>';
			$output .= '</li>';
		}}
		echo $output;
	}
	
	function getXml($url) {		
		$ch = curl_init();
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$content = curl_exec($ch);
		curl_close($ch);
		
		if ($content) {
			if (function_exists('simplexml_load_file')) {
				$xml = new SimpleXMLElement($content);
				return $xml;
			} else {
				$this->error = true;
			}
		} else {
			$this->error = true;
		}
	}
}


add_action('wp_head', 'what_twitter_say_head');
function what_twitter_say_head() {
	$myOptions   = get_option('what_twitter_say_options');
	if($myOptions['useDefaCss']){
	?>
		<style type="text/css" media="screen">
        #whattwittersay ul { margin:0px; padding:0px; margin-top: 5px; }
        #whattwittersay ul li { border-bottom:solid 1px #fff; list-style:none; list-style-position:outside; list-style-image:none; margin-bottom:5px; float:left; width:100%; font-size:11px; line-height:1.4em; }
        #whattwittersay ul li .tweetAvatar { float:left; }
            #whattwittersay ul li .tweetAvatar img { width:32px; height:32px; }
        
        #whattwittersay ul li .tweetContent, #whattwittersay ul li .tweetInfo { padding-left:42px; }
			#whattwittersay ul li .tweetContent b { color:#603; }
			#whattwittersay ul li .tweetContent a { color:#603; }
        #whattwittersay ul li .tweetInfo { margin-top:0px; font-size:9px; }
        	#whattwittersay ul li .tweetInfo .tweetUser { font-weight:bold; color:#06C; }
			#whattwittersay ul li .tweetInfo .tweetTime { color:#603; }
			
		#whattwittersay ul li p.tweetContent a, #whattwittersay ul li p.tweetInfo a { display: inline; border:none; }
		
        #whattwittersay ul li p { margin:0px; }
		
		
		
		
		#justmytweet ul { margin:0px; padding:0px; margin-top: 5px; }
        #justmytweet ul li { border-bottom:solid 1px #fff; list-style:none; list-style-position:outside; list-style-image:none; margin-bottom:5px; float:left; width:100%; font-size:11px; line-height:1.4em; }
        #justmytweet ul li .tweetAvatar { float:left; }
            #justmytweet ul li .tweetAvatar img { width:32px; height:32px; }
        
        /*#justmytweet ul li .tweetContent, #justmytweet ul li .tweetInfo { padding-left:42px; }*/
			#justmytweet ul li .tweetContent b { color:#603; }
			#justmytweet ul li .tweetContent a { color:#603; }
        #justmytweet ul li .tweetInfo { margin-top:0px; font-size:9px; }
        	#justmytweet ul li .tweetInfo .tweetUser { font-weight:bold; color:#06C; }
			#justmytweet ul li .tweetInfo .tweetTime { color:#603; }
			
		#justmytweet ul li p.tweetContent a, #justmytweet ul li p.tweetInfo a { display: inline; border:none; }
		
        #justmytweet ul li p { margin:0px; }
        </style>
	<?php 
}}

?>