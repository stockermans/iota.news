<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>IOTA.news</title>
    <link rel="shortcut icon" href="favicon.ico">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <style>
        a:visited { 
            background-color: #f5f5f5;
        }
        .list-group-item{
            word-wrap: break-word;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
      
      <header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/">IOTA.news<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/about">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown08" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Sources</a>
        <div class="dropdown-menu" aria-labelledby="dropdown08">
          <a class="dropdown-item" target="_blank" href="https://blog.iota.org">Iota Foundation Blog</a>
          <a class="dropdown-item" target="_blank" href="https://www.youtube.com/channel/UCfq6x_5wCrXh0mUa-1iRX9g">Hello IOTA Youtube Channel</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
    </header>
    
    <main role="main" class="flex-shrink-0">
        <div class="container mt-5">
            <div class="row top-container">
                <?php
                    function getContent() {
                        //Thanks to https://davidwalsh.name/php-cache-function for cache idea
                        $file = "./feed-cache.txt";
                        $current_time = time();
                        $expire_time = 5 * 60;
                        $file_time = filemtime($file);

                        if(file_exists($file) && ($current_time - $expire_time < $file_time)) {
                            return file_get_contents($file);
                        }
                        else {
                            $content = getFreshContent();
                            file_put_contents($file, $content);
                            return $content;
                        }
                    }

                    function getFreshContent() {
                        $html = "";
                        $newsSourceOne = array(
                            array(
                                "title" => "Iota Foundation Blog",
                                "url" => "https://blog.iota.org/feed"
                            )
                        );
                        $newsSourceTwo = array(
                            array(
                                "title" => "Hello IOTA Youtube",
                                "url" => "http://feedmix.novaclic.com/atom2rss.php?source=https%3A%2F%2Fwww.youtube.com%2Ffeeds%2Fvideos.xml%3Fchannel_id%3DUCfq6x_5wCrXh0mUa-1iRX9g"
                            )
                        );

                        function getFeed($url){
                            $html = "";
                            $rss = simplexml_load_file($url);
                            $count = 0;
                            $html .= '<ul class="list-group">';
                            foreach($rss->channel->item as$item) {
                                $count++;
                                if($count > 15){
                                    break;
                                }
                                $html .= '<a class="list-group-item list-group-item-action" target="_blank" href="'.htmlspecialchars($item->link).'">'.htmlspecialchars($item->title).'</a>';
                            }
                            $html .= '</ul>';
                            return $html;
                        }

                        $html .= '<div class="col-md-6">';
                        foreach($newsSourceOne as $source) {
                            $html .= '<h2 class="mt-4">'.$source["title"].'</h2>';
                            $html .= getFeed($source["url"]);
                        }
                        $html .= '</div><div class="col-md-6">';

                        foreach($newsSourceTwo as $sourceTwo) {
                            $html .= '<h2 class="mt-4">'.$sourceTwo["title"].'</h2>';
                            $html .= getFeed($sourceTwo["url"]);
                        }
                        $html .= '</div>';                        
                        return $html;
                    }

                    print getContent();
                ?>               
            </div>
        </div>
    </main>
    <footer class="footer mt-auto py-3">
      <div class="container">
      </div>
    </footer>
</body>
</html>