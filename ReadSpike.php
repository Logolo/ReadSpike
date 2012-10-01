<?php
/*
* Caches API calls to a local file which is updated on a 
* given time interval.
*/

  require 'API_cache.php';
  
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <title>ReadSpike News Aggregator</title>
  
  <link rel="stylesheet" href="css/ReadSpike.css?3984793274" type="text/css">		  
  
  <meta name="viewport" content="width=device-width, maximum-scale=1.0" />
  <meta name="author" content="blackspike.com">
  <meta name="description" content="Simple php/json/html5/css3 news aggregator by blackspike.com">  
  
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35227261-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
 
 </head>
 
 <body id="home" class="light">
 
 <header class="header-search">

<h1 class="logo-header">ReadSpike beta</h1>
 
  <form action="https://www.google.com/search" method="get" target="_blank">
  
    <input type="text" placeholder="Search google..." name="q" />
    
  
  </form>
 
 </header>
 
 <div class="col-group">


  <div class="col">
 
    <h1><a href="http://www.reddit.com" target="_blank">Reddit</a></h1> 
    
    <?php //!REDDIT
    
        $cache_file = 'cache/api-cache-Reddit.json';
        $api_call = 'http://www.reddit.com/.json?limit=100';
        $cache_for = 3; // cache results for five minutes
        
        $api_cache = new API_cache ($api_call, $cache_for, $cache_file);
        if (!$res = $api_cache->get_api_cache())
          $res = "Error: Could not load cache - please reload\n";
          
        $decodeReddit = json_decode($res, true);        


      echo "<ol>\n";
      
          foreach($decodeReddit[data][children] as $story){
            
          if($story[data][over_18]){echo "<li class='nsfw'>";}else{echo "<li>";}          
          
          echo "<a href=\"http://www.reddit.com/".$story[data][permalink]."\" target=\"_blank\" class=\"comments\">&#10078;</a>";
          
          echo "<a href=\"".$story[data][url]."\" target=\"_blank\" title=\"".$story[data][num_comments]." | ".$story[data][subreddit]."\" >".$story[data][title]."</a>\n"; 
          echo "</li>\n";          
          
         /* echo $story[data][subreddit]." | ".$story[data][num_comments]." | "."<a href=\"http://www.reddit.com/".$story[data][permalink]."\" target=\"_blank\">Comments</a>";*/          
         /* echo "<a href=\"".$story[data][url]."\" target=\"_blank\" class=\"thumbnail\">&#10095;</a>\n"; */
         /*"."<img src=\"".$story[data][thumbnail]."\"</img>"."*/
          
        }
        echo "<pre>";
        print_r($decode);
        echo "</pre>";
      
      /* !WRITE OUT ALL JSON
      
        echo "<pre>";
        print_r($decode);
        echo "</pre>";
      */

        echo "</ol>\n\n";        
    ?>

  </div>
  
  
  <div class="col">
 
    <h1><a href="http://news.ycombinator.com" target="_blank">Hacker News</a></h1>
  
    <?php //!HACKER NEWS
    
        $cache_file = 'cache/api-cache-HN.json';
        $api_call = 'http://api.ihackernews.com/page';
        $cache_for = 20; // cache results for twenty minutes
        
        $api_cache = new API_cache ($api_call, $cache_for, $cache_file);
        if (!$res = $api_cache->get_api_cache())
          $res = "Error: Could not load cache - please reload\n";
          
        $decodeHN = json_decode($res, true);        

      echo "<ol>\n";
      
      foreach($decodeHN[items]as $storyHN){
      
        
        echo "<li>";   
        /*echo $storyHN[postedAgo]." | ".$storyHN[commentCount]." | "."<a href=\"http://news.ycombinator.com/item?id=".$storyHN[id]."\" target=\"_blank\" class=\"comments\">&#149;</a>";*/
        echo "<a href=\"http://news.ycombinator.com/item?id=".$storyHN[id]."\" target=\"_blank\" class=\"comments\">&#10078;</a>";
        echo "<a href=\"".$storyHN[url]."\" target=\"_blank\">".$storyHN[title]."</a>"; 
        echo "</li>\n";
      }
  
      echo "</ol>\n\n";         
      
      /* !WRITE OUT ALL JSON
      
      echo "<pre>";
      print_r($decodeHN);
      echo "</pre>";
      
      */
        
  
  ?>
  
  
  
  
  
  <h1><a href="http://digg.com/" target="_blank">New Digg</a></h1>
   
  <?php //!NEW DIGG  
    
        $cache_file = 'cache/api-cache-Digg.json';
        $api_call = 'http://pipes.yahoo.com/pipes/pipe.run?_id=90ce1ca4854fc79f898e273584a8d67a&_render=json&feedcount=10&feedurl=http%3A%2F%2Fdigg.com%2Frss%2Ftopstories.xml';
        $cache_for = 7; // cache results for five minutes
        
        $api_cache = new API_cache ($api_call, $cache_for, $cache_file);
        if (!$res = $api_cache->get_api_cache())
          $res = "Error: Could not load cache - please reload\n";
          
      ob_start();
      echo $res;
      $json_body = ob_get_clean();
  
        $decodeDigg = json_decode($json_body, true);        

      echo "<ol>\n";
      
      foreach($decodeDigg[value][items] as $storyDigg){
      
      
           echo "<li><a href=\"".$storyDigg[link]."\" target=\"_blank\" title=\"".$storyDigg[description]."\" >".$storyDigg[title]."</a></li>\n"; 
          
        }
      
        echo "</ol>\n\n";  
      
?>






  </div>
  
  <div class="col">
  
  
    <h1><a href="http://www.bbc.co.uk/news" target="_blank">BBC News</a></h1> 
    
    <?php //!BBC
    
    
        $cache_file = 'cache/api-cache-BBC.json';
        $api_call = 'http://pipes.yahoo.com/pipes/pipe.run?_id=14c960a6df0000f567e08fc1c74fee15&_render=json&feedcount=10&feedurl=http%3A%2F%2Ffeeds.bbci.co.uk%2Fnews%2Frss.xml';
        $cache_for = 7; // cache results for five minutes
        
        $api_cache = new API_cache ($api_call, $cache_for, $cache_file);
        if (!$res = $api_cache->get_api_cache())
          $res = "Error: Could not load cache - please reload\n";
          
      ob_start();
      echo $res;
      $json_body = ob_get_clean();
  
        $decodeBBC = json_decode($json_body, true);        

      echo "<ol>\n";
      
      foreach($decodeBBC[value][items] as $storyBBC){
      
      
           echo "<li><a href=\"".$storyBBC[link]."\" target=\"_blank\" title=\"".$storyBBC[description]."\" >".$storyBBC[title]."</a></li>\n"; 
          
        }
      
        echo "</ol>\n\n";  
      
        
    ?>

  
  <h1><a href="http://www.pinboard.in/popular/" target="_blank">Pinboard</a></h1>
   
  <?php //!PINBOARD  
    
        $cache_file = 'cache/api-cache-Pinboard.json';
        $api_call = 'http://feeds.pinboard.in/json/popular/';
        $cache_for = 5; // cache results for five minutes
        
        $api_cache = new API_cache ($api_call, $cache_for, $cache_file);
        if (!$res = $api_cache->get_api_cache())
          $res = "Error: Could not load cache - please reload\n";
          
      ob_start();
      echo $res;
      $json_body = ob_get_clean();
  
        $decodePinboard = json_decode($json_body, true);        

      echo "<ol>\n";
      
      foreach($decodePinboard as $storyPB){
      
      
           echo "<li><a href=\"".$storyPB[u]."\" target=\"_blank\">".$storyPB[d]."</a></li>\n";
          
        }
      
        echo "</ol>\n\n";  
        
        
      
        /* !WRITE OUT ALL JSON
        
        echo "<pre>";
        print_r($decodePB);
        echo "</pre>";
        
        */

?>


  </div>
  




<!-- !/col-group -->
</div>

<footer>

   <a href="http://blackspike.com/" target="_blank">by blackspike.com</a>
    
</footer>    
   
   <a href="#home" class="back-to-top">&#8679;</a>
 
    <div class="settings"> 
     <a class="lightSwitch">light</a>
     <a class="darkSwitch">dark</a>
    </div>
    
    
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script src="js/ReadSpike.js" type="text/javascript"></script>


 </body>
</html>
