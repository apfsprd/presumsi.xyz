<?php
  require "autoload.php";
  use Abraham\TwitterOAuth\TwitterOAuth;


  if(isset($_POST['submit'])){
    $q = $_POST["query"];
    $until = $_POST["until"];
    $lang = "id";
    $result_type = $_POST["tipe"];
    $count = $_POST["count"];

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
    // $hasil = $hasil['statuses'];
    

    // var_dump($hasil[0]['text']);
    // die;
  }
  
?>
<?php include 'header.php'; ?>

<section id="mulai">
<div class="container">
  <div class="row mt-3 justify-content-center">
      <div class="col-md-8">
        <form action="" method="post">

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
</div>
</section>


<section id="hasil">
  <div class="container">
    <div class="row">

    <?php if (isset($_POST['submit'])) { ?>
      <h4>Hasil untuk <span class="badge badge-success"><?= $_POST['query']; ?></span></h4>
    <?php } ?>

    <table id="myTable" class="display" style="width:100%">
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
      <?php if(isset($_POST['submit'])) { ?>
        <?php if($hasil['statuses'] >= array(0)) {?>
          <?php
            $a = 1;
            foreach($hasil['statuses'] as $tweet) { 

            // if (PHP_SAPI != 'cli') {
            //   echo "<pre>";
            // }
          
            $strings = array(
              1 => $tweet['text']
            );
          
            require_once __DIR__ . '/autoload.php';
            $sentiment = new \PHPInsight\Sentiment(); 
          ?>

            <tr>
              <th scope="row"><?= $a++ ?></th>
              <td><img src="<?= $tweet['user']['profile_image_url_https']; ?>" class="img-thumbnail" alt=""></td>
              <td><?= $tweet['user']['name']; ?> <br> <p class="text-muted"> <?= $tweet['user']['screen_name']; ?></p></td>
              <td><?= $tweet['text']; ?></td>
              <td><?= $tweet['created_at']; ?></td>
              <td><a href="https://twitter.com/i/web/status/<?= $tweet['id_str']; ?>" Target="_blank">link</a></td>
              <td><?php 
                  $i=1;
                  foreach ($strings as $string) {

                    // calculations:
                    $scores = $sentiment->score($string);
                    $class = $sentiment->categorise($string);

                    // output:
                    if (in_array("pos", $scores)) {
                        echo "Got positif";
                    } 

                    $color=NULL;
                    if($class =='positif') {
                        $color='success';
                        
                    }
                    else if($class =='negatif') {
                        $color='danger';
                        
                    }
                    else if($class =='netral') {
                        $color='secondary';
                        
                    }

                    ?>
                    
                    <span class="badge badge-<?= $color; ?>" style="font-size: 18px;"><?= $class; ?></span>

                  <?php 
                    // var_dump($scores);
                    // foreach ($scores as $skor) {
                    //   echo $skor;
                    // }
                    // echo "";
                    $i++; } 
                  ?>
              </td>
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
  </div>
</section>
  
  <?php include 'footer.php'; ?>