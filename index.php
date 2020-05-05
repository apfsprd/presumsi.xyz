<?php
  require "autoload.php";
  use Abraham\TwitterOAuth\TwitterOAuth;
  if(isset($_POST['submit'])){
    $q = $_POST["query"];
    $until = $_POST["until"];
    $lang = "id";
    $result_type = $_POST["tipe"];
    $count = $_POST["count"];

    // var_dump($count);
    // die;

    $consumer_key = 'TeqroXqCXV7tXXdiYJITIEboE';
    $consumer_secret = 'j3ST0KxNONYvg0lX6EOr4zpoOI1HwTcsJsAClwB1VNz6fBKxg2';
    $access_token = '1004847962256695296-tVa5ARrvt89rDMZNv2aAQgWedUqFsi';
    $access_token_secret = 'kBbkqPmJGQekNfF3hw0TW6YhgKGTG7zgMfwEqeFOsvynp';

    $connection = new TwitterOAuth( $consumer_key, $consumer_secret , $access_token, $access_token_secret);
    $connection->setTimeouts(10, 15);
    $url = $connection->url("oauth/authorize", ["oauth_token" => $access_token]);
    
    $statuses = $connection->get("search/tweets", [
      "q" => $q, 
      "until" => $until,
      "lang" => $lang,
      "result_type" => $result_type,
      "count" => $count
    ]);
    $hasil = json_decode(json_encode($statuses), true);
    
    // var_dump($hasil);
    // die;
  }
  
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- FONT MONTSERRAT-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <title>Sentiment Analysis - @apfsprd</title>
  </head>

  <body>
    
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><b><i>Presumsi</i></b></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ml-auto">
                  <a class="nav-item nav-link btn btn-primary active" href="#mulai">Mulai</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- /NAVBAR -->

    <!-- ===================================================== JUMBOTRON -->
    <div class="jumbotron cover jumbotron-fluid">

      <div class="container">
    
        <div class="row align-items-center">
    
            <div class="col">
                <h1 class="display-4" data-aos="fade-up" data-aos-duration="3000">Analisis Cuitan warganet di twitter</h1>
                <p class="lead" data-aos="fade-up" data-aos-duration="3000">Tweet (cuitan) di twitter sebagai data yang dianalisis</p>
                <a href="#mulai" class="btn btn-success" data-aos="fade-up" data-aos-duration="3000">Mulai Analisis</a>
            </div>
    
            <div class="col">
                <img src="http://localhost/datamining-apfsprd/img/landingpage2.svg" alt="">
            </div>
    
        </div>
    
      </div>
    </div>
    <!-- ===================================================== JUMBOTRON -->
    
    <div class="container">

      <div class="row mt-3 justify-content-center" id="mulai">
          <div class="col-md-8">
            <form action="index.php" method="post">

              <h1 class="text-center"><b>Mulai Analisis</b></h1>
              <h5 class="text-center mb-4">Isi form untuk bisa mendapatkan cuitan (Tweet) yang sesuai</h6>
              <div class="row">
                
                <div class="col">
                  <label for="">Kata kunci</label>
                  <input type="text" class="form-control" placeholder="Kata kunci" id="search-input" name="query" required >
                  <small class="form-text text-muted mb-3">
                    Kata kunci yang ingin di analisis
                  </small>
                </div>

                <div class="col">
                  <label for="">Tipe hasil</label>
                  <select id="tipe" name="tipe" class="form-control">
                    <option value="" selected>Pilih</option>
                    <option value="popular">Populer</option>
                    <option value="recent">Terkini</option>
                    <option value="mixed">Campuran</option>
                  </select>
                  <small class="form-text text-muted mb-3">
                    Populer : hanya Tweet yang paling populer <br> Terkini : hanya tweet yang terkini <br> Campuran : gabungan dari populer dan terkini 
                  </small>
                </div>

              </div>

              <div class="row">

                <div class="col">
                  <label for="">Jumlah tweet</label>
                  <input type="number" name="count" class="form-control" id="count" placeholder="Jumlah tweet">
                  <small class="form-text text-muted mb-3">
                    Default jumlah tweet yang diambil adalah 15 dan maksimal 100 cuitan (tweet)
                  </small>
                </div>

                <div class="col">
                  <label for="">Tanggal</label>
                  <input type="date" class="form-control" id="until" name="until" placeholder="Tanggal">
                  <small class="form-text text-muted mb-3">
                    Mengambil Tweet yang dibuat 7 hari sebelum tanggal yang diberikan.
                  </small>
                </div>

              </div>

              <div class="row">
                <div class="col">
                  <button class="btn btn-outline-warning btn-block mt-3" type="reset"><b>Reset</b></button>
                </div>

                <div class="col">
                  <button class="btn btn-success btn-block mt-3" type="submit" id="submit" name="submit">Kirim</button>
                </div>
              </div>
            </form>
          </div>
      </div>

      
      <!-- SEARCH -->
      <div class="row" id="sentiment">

      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Photo</th>
            <th scope="col">User</th>
            <th scope="col">Tweet</th>
            <th scope="col">Tanggal</th>
            <th scope="col">link</th>
            <th scope="col">Sentiment</th>
          </tr>
        </thead>
        <tbody>
        <?php if(isset($_POST['submit'])) {?>
          <?php if($hasil['statuses'] >= array(0)) {?>
            <?php
              $i = 1;
              foreach($hasil['statuses'] as $tweet) { 
            ?>
              <tr>
                <th scope="row"><?= $i++ ?></th>
                <td><img src="<?= $tweet['user']['profile_image_url_https']; ?>" class="img-thumbnail" alt=""></td>
                <td><?= $tweet['user']['name']; ?> <br> <p class="text-muted"> <?= $tweet['user']['screen_name']; ?></p></td>
                <td><?= $tweet['text']; ?></td>
                <td><?= $tweet['created_at']; ?></td>
                <td><a href="https://twitter.com/i/web/status/<?= $tweet['id_str']; ?>" Target="_blank"><h6>Link</h6></a></td>
                <td>Sentiment</td>
              </tr>
            <?php } ?>
          <?php } else {?>
              <tr>
                <td colspan="7" class="text-center"><i>Tweet tidak ada yang cocok dengan kata kunci</i></td>
              </tr>
          <?php } ?>
          <?php } else { ?>
            <tr>
                <td colspan="7" class="text-center"><i>Query belum dikirim</i></td>
              </tr>
        <?php } ?>
       
        </tbody>
      </table>

    </div>
    <!-- /SEARCH -->
      


  </div>
   <!-- ===================================================== FOOTER -->
   <ul class="nav justify-content-center" style="background-color: #005698 !important">
    <p style="color: white; font-size: 15px; margin-top: 10px; "><i>[ ] dengan &hearts; di Tangerang, Banten</i></p>
  </ul>
  <!-- ===================================================== FOOTER -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>  </body>

    <!-- Script.js -->
    <!-- <script src="script.js"></script> -->

    <!-- sha1 -->
    <!-- <script src="CryptoJS-v3.1.2/rollups/hmac-sha1.js"></script> -->

    <!-- sha256 -->
    <!-- <script src="CryptoJS-v3.1.2/rollups/hmac-sha256.js"></script> -->
    <!-- <script src="CryptoJS-v3.1.2/components/enc-base64-min.js"></script> -->
    <!-- <script src="oauth-1.0a.js"></script> -->

    <!-- AOS Animate -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script> AOS.init(); </script>

</html>