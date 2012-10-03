<?php
/*
* Caches API calls to a local file which is updated on a
* given time interval.
*/

  header("Cache-Control: max-age=1");
  require 'API_cache.php';

?>
<!DOCTYPE html>

<html>

 <head>

  <meta charset="UTF-8">

  <title>ReadSpike Simple news Aggregator</title>

  <link rel="stylesheet" href="css/ReadSpike.css" type="text/css">

  <meta name="viewport" content="width=device-width, maximum-scale=1.0" />
  <meta name="author" content="blackspike.com">
  <meta name="description" content="Simple news aggregator by blackspike.com">

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


<!-- !HEADER -->

 <header class="header-search">

  <h1 class="logo-header">ReadSpike beta</h1>

  <form action="https://www.google.com/search" method="get" target="_blank">

    <input type="text" placeholder="Search google..." name="q" />

  </form>

 </header>



<!-- !COLUMNS -->


 <div class="col-group">


<!-- !RIGHT COL -->

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

          //nsfw!
          if($story[data][over_18]){echo "<li class='nsfw'>";}else{echo "<li>";}


          // title
          echo "<a href=\"".$story[data][url]."\" target=\"_blank\" class=\"story-title\" title=\"".$story[data][num_comments]." | ".$story[data][subreddit]."\" >".$story[data][title]."</a>\n";



          // comments
          echo "<a href=\"http://www.reddit.com/".$story[data][permalink]."\" target=\"_blank\" class=\"comments\" title=\"comments\">&#10078;</a>";


          // if image show show hide controls
          $imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif", "svg");
          $url = $story[data][url];
          $urlExt = pathinfo($url, PATHINFO_EXTENSION);

          if (in_array($urlExt, $imgExts)) {

            echo "<a title='Hide image' class='hide-image'>&times;</a>";
            echo "<a title='Show image' href=\"".$story[data][url]."\" class='show-image'>&#x25BE;</a>";


          }

          // thumbnail
          if($story[data][thumbnail]){echo "<div class='tooltip-holder'><img src=".$story[data][thumbnail]." class='thumbnail' /></div>";}


          // detect if show image layer
          $imgExts = array("gif", "jpg", "jpeg", "png", "tiff", "tif", "svg");
          $url = $story[data][url];
          $urlExt = pathinfo($url, PATHINFO_EXTENSION);

          if (in_array($urlExt, $imgExts)) {

            echo "<div class='full-image'></div>";

          }

           echo "</li>\n";

        }
      /* !WRITE OUT ALL JSON

        echo "<pre>";
        print_r($decode);
        echo "</pre>";
      */

        echo "</ol>\n\n";
    ?>

  </div>



<!-- !MIDDLE COL -->

  <div class="col">

    <h1><a href="http://news.ycombinator.com" target="_blank">Hacker News</a></h1>

    <?php //!HACKER NEWS

        $cache_file = 'cache/api-cache-HN.json';
        $api_call = 'http://open.dapper.net/transform.php?dappName=HNhomepage&transformer=JSON&applyToUrl=http%3A%2F%2Fnews.ycombinator.com%2F';
        $cache_for = 10; // cache results for ten minutes

        $api_cache = new API_cache ($api_call, $cache_for, $cache_file);
        if (!$res = $api_cache->get_api_cache())
          $res = "Error: Could not load cache - please reload\n";

        $decodeHN = json_decode($res, true);

      echo "<ol>\n";

      foreach($decodeHN[groups][Post]as $storyHN){


        echo "<li>";
        /*echo $storyHN[postedAgo]." | ".$storyHN[commentCount]." | "."<a href=\"http://news.ycombinator.com/item?id=".$storyHN[id]."\" target=\"_blank\" class=\"comments\">&#149;</a>";*/
        echo "<a href=\"".$storyHN[NumComments][0][href]."\" target=\"_blank\" class=\"comments\" title=\"comments\">&#10078;</a>";
        echo "<a href=\"".$storyHN[Title][0][href]."\" target=\"_blank\">".$storyHN[Title][0][value]."</a>";
        echo "</li>\n";
      }

      echo "</ol>\n\n";

      /* !WRITE OUT ALL JSON

      echo "<pre>";
      print_r($decodeHN);
      echo "</pre>";

      */

  ?>


<!-- !DIGG -->


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



<!-- !LEFT COL -->


  <div class="col">



<!-- !NEWS HEADER -->

    <h1>
    <a href="http://www.bbc.co.uk/news" target="_blank" class="tab-header bbc-title" data-source="bbc-news">BBC</a>
    <a href="http://news.google.com/" target="_blank" class="tab-header GNews-title" data-source="GNews-news">Google</a>
    </h1>


<!-- !BBC NEWS -->

  <section class="tab-content bbc-news">
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

  </section>



<!-- !GOOGLE NEWS -->


  <section class="tab-content GNews-news">
  <?php //!GOOGLE NEWS

        $cache_file = 'cache/api-cache-GNews.json';
        $api_call = 'http://ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=38&q=http%3A%2F%2Fnews.google.com%2Fnews%3Foutput%3Drss';
        $cache_for = 7; // cache results for five minutes

        $api_cache = new API_cache ($api_call, $cache_for, $cache_file);
        if (!$res = $api_cache->get_api_cache())
          $res = "Error: Could not load cache - please reload\n";

      ob_start();
      echo $res;
      $json_body = ob_get_clean();

        $decodeGNews = json_decode($json_body, true);

      echo "<ol>\n";

      foreach($decodeGNews[responseData][feed][entries] as $storyGNews){


           echo "<li><a href=\"".$storyGNews[link]."\" target=\"_blank\" title=\"".$storyGNews[contentSnippet]."\" >".$storyGNews[title]."</a></li>\n";

        }

        echo "</ol>\n\n";

      /* !WRITE OUT ALL JSON

      echo "<pre>";
      print_r($decodeGNews);
      echo "</pre>";
      */

?>

  </section>


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



<!-- !FOOTER -->

<footer>

   <a href="http://blackspike.com/" target="_blank">by blackspike.com</a>

</footer>


   <a href="#home" class="back-to-top">&#8679;</a>

    <div class="settings">
     <a class="darkSwitch">dark</a>
     <a class="lightSwitch">light</a>
    </div>



  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script src="js/ReadSpike.js" type="text/javascript"></script>

<!--

<script type="text/javascript">
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/41GKPc60EN3P7KhrnyTmTg.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script

-->

 </body>
</html>
#8679;</a>
 
    <div class="settings"> 
     <a class="darkSwitch">dark</a>
     <a class="lightSwitch">light</a>
    </div>
    
    
  
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
  <script src="js/ReadSpike.js" type="text/javascript"></script>

<!--

<script type="text/javascript">
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/41GKPc60EN3P7KhrnyTmTg.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script

-->

 </body>
</html>
