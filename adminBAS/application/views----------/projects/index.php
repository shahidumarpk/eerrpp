<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Proto! MultiSelect</title>
    
    <link rel="stylesheet" href="css/test.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
    <script src="js/protoculous-effects-shrinkvars.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/textboxlist.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/test.js" type="text/javascript" charset="utf-8"></script>
  </head>
  
  <body id="test">    
    <h1>Proto! MultiSelect [Facebook + Hotmail]</h1>
    <div id="text"></div>
    <form action="" method="post" accept-charset="utf-8">
      <ol>
        <li id="facebook-list" class="input-text">
          <label>input</label>
          <input type="text" value="" id="facebook-demo" />
          <div id="facebook-auto">
            <div class="default">Type the name of an argentine writer you like</div> 
            <ul class="feed">
            </ul>
          </div>
        </li>
      </ol>
    
    <div id="button_container">
        <button onclick="tlist2.update(); alert($F('facebook-demo'));return false;">Get Values</button>
    </div>
    
	<script language="JavaScript">
        document.observe('dom:loaded', function(){
          // init
          tlist2 = new FacebookList('facebook-demo', 'facebook-auto',{fetchFile:'fetched.php'});
          // fetch and feed
          new Ajax.Request('json.php', {
            onSuccess: function(transport) {
                transport.responseText.evalJSON(true).each(function(t){tlist2.autoFeed(t)});
            }
          });
        });    
    </script>
  </body>  
</html>