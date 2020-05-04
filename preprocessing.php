<?php
      //fungsi preproses menerima teks dan menerapkan beberapa tugas awal 
      //fase indexing dokumen teks
      function preproses($teks) {
      
          //1. ubah ke huruf kecil            
          $teks = strtolower(trim($teks));
          
          //hilangkan tanda baca
          $teks = str_replace("'", " ", $teks);

          $teks = str_replace("-", " ", $teks);
      
          $teks = str_replace(")", " ", $teks);
      
          $teks = str_replace("(", " ", $teks);
      
          $teks = str_replace("/", " ", $teks);

          $teks = str_replace("\"", " ", $teks);
      
          $teks = str_replace("=", " ", $teks);
      
          $teks = str_replace(".", " ", $teks);
      
          $teks = str_replace(",", " ", $teks);
      
          $teks = str_replace(":", " ", $teks);
      
          $teks = str_replace(";", " ", $teks);
      
          $teks = str_replace("!", " ", $teks);
      
          $teks = str_replace("?", " ", $teks);
                      
          //2. hapus stoplist
          //daftar stop word diletakkan di array
          //anda boleh menggunakan database sebagai gantinya
          $astoplist = array ("yang", "juga", "dari", "dia", "kami", "kamu", "ini", "itu", "atau", "dan", "tersebut", "pada", "dengan", "adalah", "yaitu");     
                                                  
          foreach ($astoplist as $i => $value) {
              $teks = str_replace($astoplist[$i], "", $teks);
          }
                  
          //3. terapkan stemming

          
          //pemetaan term --> stem hanya menggunakan array
          //index ganjil menunjukkan term dan index genap adalah stem dari term tersebut
          //anda boleh menggunakan database sebagai gantinya
          $astemlist = array("pertemuan", "temu", "bertemu", "temu", "cr9", "cristiano ronaldo", "berharap", "harap");
          
          //perhatikan cara mengubah suatu term ke bentuk stemnya
          for ($i=0; $i<count($astemlist); $i = $i +2) {
              //ganti term (jika ditemukan term pada index ganjil) dengan stem pada index genap ($i=1)        
              $teks = str_replace($astemlist[$i], $astemlist[$i+1], $teks);
          }
                      
      
          //hilangkan ruang kosong di awal & akhir teks   
          $teks = trim($teks);
      
          return $teks;
      
      } //end function
      ?>