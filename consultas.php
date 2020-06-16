<?php
include 'database.php';



include 'Classes/SelectionSort.class.php';
include 'Classes/InsertionSort.class.php';
include 'Classes/BubbleSort.class.php';
include 'Classes/QuickSort.class.php';
include 'Classes/MergeSort.class.php';
include 'Classes/HeapSort.class.php';
include 'Classes/CountingSort.class.php';
include 'Classes/RadixSort.class.php';
include 'Classes/BucketSort.class.php';





//include 'autoLoader.inc.php';
?>

<html>

<head>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
  <meta charset='utf-8'>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <title>ROBR</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <meta name='viewport' content='width=device-width, initial-scale=1'>
  <link rel='stylesheet' type='text/css' media='screen' href='https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css'>
  <link rel='stylesheet' type='text/css' media='screen' href="styles/grafico.css">
  <link rel="stylesheet" type="text/css" href="styles/geral.css">
</head>

<body>
  <style>
    a {
      text-decoration: none;
      z-index: 200;
    }

    .background {
      background-color: #252429;
      height: 100%;
      width: 100%;
    }

    .dropbtn {
      background-color: #1f1e22;
      color: white;
      padding: 16px;
      font-size: 16px;
      border: none;
      cursor: pointer;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown:hover .dropbtn {
      background-color: #252429;
    }

    .line-chart {
      animation: fadeIn 600ms cubic-bezier(0.57, 0.25, 0.65, 1) 1 forwards;
      opacity: 0;
      max-width: 1140px;
      width: 100%;
    }

    .aspect-ratio {
      height: 0;
      padding-bottom: 50%;
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }
  </style>
  <script>
    var votos = 0;
    var cands = 0;
    var ano;
    var cargo;
  </script>

  <div style="width:100%;padding:none;">
    <div class="title-box">ROBR</div>
    <br>
    <h2 align="center" style="color:gray;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Consultar Resultados</h2>
    <br>

    <center>
      <div class="dropdown">
        <button class="dropbtn">Resultados por Vereador</button>
        <div class="dropdown-content">
          <?php
          $query = "SELECT ID, desc_ano FROM ANO";
          $result = mysqli_query($conn, $query);
          while ($coluna = mysqli_fetch_array($result)) {
            echo "<a href='consultas.php?ano=" . $coluna['ID'] . "&cargo=1'>" . $coluna['desc_ano'] . "</a>";
          }

          ?>
          <a href="consultas.php?ano=2020">2020</a>
        </div>
      </div>

      <div class="dropdown">
        <button class="dropbtn">Resultado por Prefeito</button>
        <div class="dropdown-content">
          <?php
          $query = "SELECT ID, desc_ano FROM ANO";
          $result = mysqli_query($conn, $query);
          while ($coluna = mysqli_fetch_array($result)) {
            echo "<a href='consultas.php?ano=" . $coluna['ID'] . "&cargo=2'>" . $coluna['desc_ano'] . "</a>";
          }

          ?>
          <a href="consultas.php?ano=2020">2020</a>
        </div>
      </div>

      <div class="dropdown">
        <button class="dropbtn">Resultado por zona eleitoral</button>
        <div class="dropdown-content">
          <?php
          $query = "SELECT ID, desc_ano FROM ANO";
          $result = mysqli_query($conn, $query);
          while ($coluna = mysqli_fetch_array($result)) {
            echo "<a href='consultas.php?ano=" . $coluna['ID'] . "&cargo=3'>" . $coluna['desc_ano'] . "</a>";
          }

          ?>
          <a href="consultas.php?ano=2020">2020</a>
        </div>
      </div>
    </center>

    <!---<div class="dropdown">
             <button class="dropbtn">Algoritimos</button>
             <div class="dropdown-content">
             <a  href="BubbleSort.php">BubbleSort</a>
             <a  href="SelectionSort.php">SelectionSort</a>
             <a  href="InsertionSort.php">InsertionSort</a>
             <a  href="QuickSort.php">QuickSort</a>
             <a  href="MergeSort.php">MergeSort</a>
               </div>
           </div>
           
       
          <a href="main.php" class="input-1"> sair </a>--->
    <?php

    if (@$_REQUEST['ano'] != "2020" && @$_REQUEST['ano'] != null) {
      $idAno = @$_REQUEST['ano'];



      $array;
      $votos;
      $cands;
      $cont = 0;


      if (@$_REQUEST['cargo'] == "1") {

        $query = "SELECT ID, desc_ano FROM ANO";
        $result = mysqli_query($conn, $query);
        while ($coluna = mysqli_fetch_array($result)) {
          if ($idAno == $coluna['ID']) {
            echo "<center><div class='container header-votacao'>
                   <h2>Resultado eleições para verador </h2>"
              . "<p>O gráfico abaixo apresenta o resultado oredenado da eleição para vereadores do primeiro turno do ano de " . $coluna['desc_ano'] . "</p>"
              . "</div></center>";
          }
        }



        $query = "SELECT SUM(VOT.qtd_votos) as qtd_votos ,CAND.nome, part.sigla, VOT.desc_cargo,sit.situacao FROM `votacao_zona_secao` AS VOT INNER JOIN candidato AS CAND ON CAND.num_cand = VOT.NUM_VOTAVEL and CAND.id_ano = VOT.ID_ANO inner join partido as part on cand.id_partido = part.id inner join situacao_tot as sit on sit.id = CAND.id_situacao WHERE VOT.DESC_CARGO = 'VEREADOR' AND vot.id_ano = '$idAno' AND SIT.SITUACAO = 'ELEITO' GROUP BY CAND.nome";

        $result = mysqli_query($conn, $query);


        while ($coluna = mysqli_fetch_array($result)) {

          $array[$cont++] = $coluna;
        }
        if (@$_REQUEST['btn'] != null) {

          $algoritimo = $_REQUEST['btn'];
          switch ($algoritimo) {

            case 1:
              $array = InsertionSort($array, $cont);
              break;
            case 2:
              $array = SelectionSort($array, $cont);
              break;
            case 3:
              $array = BubbleSort($array);
              break;
            case 4:
              $array = quickSort($array, 0, count($array) - 1);
              break;
            case 5:
              break;
            case 6:
              break;
            case 7:
              break;
            case 8:
              break;
          }
        }





    ?>

        <br><br><br>
        <div class="line-chart">
          <div class="aspect-ratio">
            <canvas id="chart"></canvas>
          </div>
        </div>

        <br>
        <center>
          <div class="container" id="opcoes">
            <form action="#?ano=<?php echo $idAno ?>&cargo=1" method="post">
              <button type="submit" name="btn" value="1" class="btn">Insert sort</button>
              <button type="submit" name="btn" value="2" class="btn">Selection sort</button>
              <button type="submit" name="btn" value="3" class="btn">Bubble sort</button>
              <button type="submit" name="btn" value="4" class="btn">Quick Sort</button>
              <button type="submit" name="btn" value="5" class="btn">Merge Sort</button>
              <button type="submit" name="btn" value="6" class="btn">Heap Sort</button>
              <button type="submit" name="btn" value="7" class="btn">Counting Sort</button>
              <button type="submit" name="btn" value="8" class="btn">Radix Sort</button>
              <button type="submit" name="btn" value="9" class="btn">Bucket Sort</button>
            </form>
          </div>
          <center>
            <div class="container" style="width:80%;" id="results">
              <table id="tabela" class="tabela table-dark" style="width:100%">
                <thead>
                  <tr>
                    <th>Qtd</th>
                    <th>Nome</th>
                    <th>Partido</th>
                    <th>Cargo</th>
                    <th>Cidade</th>
                    <th>Situação</th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  for ($i = 0; $i < $cont; $i++) {
                    if ($array[$i]['qtd_votos'] != null && $array[$i]['nome'] != null) {
                      echo "<tr>"
                        . "<td>" . $array[$i]['qtd_votos'] . "</td>"
                        . "<td>" . $array[$i]['nome'] . "</td>"
                        . "<td>" . $array[$i]['sigla'] . "</td>"
                        . "<td>" . $array[$i]['desc_cargo'] . "</td>"
                        . "<td>Curitiba</td>"
                        . "<td>" . $array[$i]['situacao'] . "</td>"
                        . "</tr>";
                    }
                  }
                  ?>
                </tbody>

              </table>
            </div>
          </center>




          <?php

          for ($i = 0; $i < $cont; $i++) {
            if ($array[$i]['qtd_votos'] != null && $array[$i]['nome'] != null) {
              $votos[$i] = $array[$i]['qtd_votos'];
              $cands[$i] = $array[$i]['nome'];
            }
          }
        } else if (@$_REQUEST['cargo'] == "2") {


          $query = "SELECT SUM(VOT.qtd_votos) as qtd_votos ,CAND.nome, part.sigla, VOT.desc_cargo,sit.situacao FROM `votacao_zona_secao` AS VOT INNER JOIN candidato AS CAND ON CAND.num_cand = VOT.NUM_VOTAVEL and CAND.id_ano = VOT.ID_ANO inner join partido as part on cand.id_partido = part.id inner join situacao_tot as sit on sit.id = CAND.id_situacao WHERE VOT.DESC_CARGO = 'PREFEITO' AND vot.id_ano = '$idAno' AND SIT.SITUACAO LIKE '%ELEITO%' GROUP BY CAND.nome";

          $result = mysqli_query($conn, $query);


          while ($coluna = mysqli_fetch_array($result)) {
            $array[$cont++] = $coluna;
          }
          if (@$_REQUEST['btn'] != null) {

            $algoritimo = $_REQUEST['btn'];
            switch ($algoritimo) {

              case 1:
                $array = InsertionSort($array, $cont);
                break;
              case 2:
                $array = SelectionSort($array, $cont);
                break;
              case 3:
                $array = BubbleSort($array);
                break;
              case 4:
                $array = quickSort($array, 0, count($array) - 1);
                break;
              case 5:
                break;
              case 6:
                break;
              case 7:

                break;
              case 8:
                $arr = [];
                for ($i = 0; $i < count($array); $i++) {
                  $arr[$i] = $array[$i]['qtd_votos'];
                }
                $arr = radixSort($arr, count($arr));
                $arrAux = [];
                for ($i = 0; $i < count($arr); $i++) {
                  for ($j = 0; $j < count($array); $j++) {
                    if ($arr[$i] == $array[$j]['qtd_votos']) {
                      $arrAux[$i] = $array[$j];
                      break;
                    }
                  }
                }
                $array = $arrAux;
                break;
              case 9:
                $arr = [];
                for ($i = 0; $i < count($array); $i++) {
                  $arr[$i] = $array[$i]['qtd_votos'];
                }
                bucketSort($arr);
                $arrAux = [];
                for ($i = 0; $i < count($arr); $i++) {
                  for ($j = 0; $j < count($array); $j++) {
                    if ($arr[$i] == $array[$j]['qtd_votos']) {
                      $arrAux[$i] = $array[$j];
                      break;
                    }
                  }
                }
                $array = $arrAux;
                break;
            }
          }
          ?>

          <br><br><br>
          <div class="line-chart">
            <div class="aspect-ratio">
              <canvas id="chart"></canvas>
            </div>
          </div>

          <br>
          <center>
            <div class="container" id="opcoes">
              <form action="#?ano=<?php echo $idAno ?>&cargo=1" method="post">
                <button type="submit" name="btn" value="1" class="btn">Insert sort</button>
                <button type="submit" name="btn" value="2" class="btn">Selection sort</button>
                <button type="submit" name="btn" value="3" class="btn">Bubble sort</button>
                <button type="submit" name="btn" value="4" class="btn">Quick Sort</button>
                <button type="submit" name="btn" value="5" class="btn">Merge Sort</button>
                <button type="submit" name="btn" value="6" class="btn">Heap Sort</button>
                <button type="submit" name="btn" value="7" class="btn">Counting Sort</button>
                <button type="submit" name="btn" value="8" class="btn">Radix Sort</button>
                <button type="submit" name="btn" value="9" class="btn">Bucket Sort</button>
              </form>
            </div>
            <center>
              <div class="container" style="width:80%;" id="results">
                <table id="tabela" class="tabela table-dark" style="width:100%">
                  <thead>
                    <tr>
                      <th>Qtd</th>
                      <th>Nome</th>
                      <th>Partido</th>
                      <th>Cargo</th>
                      <th>Cidade</th>
                      <th>Situação</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    for ($i = 0; $i < $cont; $i++) {
                      if ($array[$i]['qtd_votos'] != null && $array[$i]['nome'] != null) {
                        echo "<tr>"
                          . "<td>" . $array[$i]['qtd_votos'] . "</td>"
                          . "<td>" . $array[$i]['nome'] . "</td>"
                          . "<td>" . $array[$i]['sigla'] . "</td>"
                          . "<td>" . $array[$i]['desc_cargo'] . "</td>"
                          . "<td>Curitiba</td>"
                          . "<td>" . $array[$i]['situacao'] . "</td>"
                          . "</tr>";
                      }
                    }
                    ?>
                  </tbody>

                </table>
              </div>
            </center>





            <?php

            for ($i = 0; $i < $cont; $i++) {
              if ($array[$i]['qtd_votos'] != null && $array[$i]['nome'] != null) {
                $votos[$i] = $array[$i]['qtd_votos'];
                $cands[$i] = $array[$i]['nome'];
              }
            }
          } else if (@$_REQUEST['cargo'] == "3") {


            $query = "SELECT sum(qtd_votos) as qtd_votos,zon.num_zona FROM `votacao_zona_secao` as vot inner join zona as zon on vot.id_zona = zon.id  WHERE vot.id_ano = '$idAno' group by zon.num_zona";

            $result = mysqli_query($conn, $query);


            while ($coluna = mysqli_fetch_array($result)) {
              $array[$cont++] = $coluna;
            }

            if (@$_REQUEST['btn'] != null) {

              $algoritimo = $_REQUEST['btn'];
              switch ($algoritimo) {

                case 1:
                  $array = InsertionSort($array, $cont);
                  break;
                case 2:
                  $array = SelectionSort($array, $cont);
                  break;
                case 3:
                  $array = BubbleSort($array);
                  break;
                case 4:

                  $arr = [];
                  for ($i = 0; $i < count($array); $i++) {
                    $arr[$i] = $array[$i]['qtd_votos'];
                  }

                  $arr = quickSort($arr);
                  $arrAux = [];
                  for ($i = 0; $i < count($arr); $i++) {
                    for ($j = 0; $j < count($array); $j++) {
                      if ($arr[$i] == $array[$j]['qtd_votos']) {
                        $arrAux[$i] = $array[$j];
                        break;
                      }
                    }
                  }
                  $array = $arrAux;
                  break;
                case 5:
                  $arr = [];
                  for ($i = 0; $i < count($array); $i++) {
                    $arr[$i] = $array[$i]['qtd_votos'];
                  }

                  $arr = mergeSort($arr);
                  $arrAux = [];
                  for ($i = 0; $i < count($arr); $i++) {
                    for ($j = 0; $j < count($array); $j++) {
                      if ($arr[$i] == $array[$j]['qtd_votos']) {
                        $arrAux[$i] = $array[$j];
                        break;
                      }
                    }
                  }
                  $array = $arrAux;

                  break;
                case 6:
                  $arr = [];
                  for ($i = 0; $i < count($array); $i++) {
                    $arr[$i] = $array[$i]['qtd_votos'];
                  }

                  $arr = heap_sort($arr);
                  $arrAux = [];
                  for ($i = 0; $i < count($arr); $i++) {
                    for ($j = 0; $j < count($array); $j++) {
                      if ($arr[$i] == $array[$j]['qtd_votos']) {
                        $arrAux[$i] = $array[$j];
                        break;
                      }
                    }
                  }
                  $array = $arrAux;
                  break;
                case 7:
                  $arr = [];
                  for ($i = 0; $i < count($array); $i++) {
                    $arr[$i] = $array[$i]['qtd_votos'];
                  }
                  $arr = countingSort($arr, count($arr), max($arr));
                  $arrAux = [];
                  for ($i = 0; $i < count($arr); $i++) {
                    for ($j = 0; $j < count($array); $j++) {
                      if ($arr[$i] == $array[$j]['qtd_votos']) {
                        $arrAux[$i] = $array[$j];
                        break;
                      }
                    }
                  }
                  $array = $arrAux;
                  break;
                case 8:
                  $arr = [];
                  for ($i = 0; $i < count($array); $i++) {
                    $arr[$i] = $array[$i]['qtd_votos'];
                  }
                  $arr = radixSort($arr, count($arr));
                  $arrAux = [];
                  for ($i = 0; $i < count($arr); $i++) {
                    for ($j = 0; $j < count($array); $j++) {
                      if ($arr[$i] == $array[$j]['qtd_votos']) {
                        $arrAux[$i] = $array[$j];
                        break;
                      }
                    }
                  }
                  var_dump($arrAux);
                  $array = $arrAux;
                  break;
              }
            }
            ?>

            <br><br><br>
            <div class="line-chart">
              <div class="aspect-ratio">
                <canvas id="chart"></canvas>
              </div>
            </div>

            <br>
            <center>
              <div class="container" id="opcoes">
                <form action="#?ano=<?php echo $idAno ?>&cargo=1" method="post">
                  <button type="submit" name="btn" value="1" class="btn">Insert sort</button>
                  <button type="submit" name="btn" value="2" class="btn">Selection sort</button>
                  <button type="submit" name="btn" value="3" class="btn">Bubble sort</button>
                  <button type="submit" name="btn" value="4" class="btn">Quick Sort</button>
                  <button type="submit" name="btn" value="5" class="btn">Merge Sort</button>
                  <button type="submit" name="btn" value="6" class="btn">Heap Sort</button>
                  <button type="submit" name="btn" value="7" class="btn">Counting Sort</button>
                  <button type="submit" name="btn" value="8" class="btn">Radix Sort</button>
                  <button type="submit" name="btn" value="9" class="btn">Bucket Sort</button>
                </form>
              </div>
              <center>
                <div class="container" style="width:80%;" id="results">
                  <table id="tabela" class="tabela table-dark" style="width:100%">
                    <thead>
                      <tr>
                        <th>Qtd</th>
                        <th>N° Zona</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php

                      for ($i = 0; $i < $cont; $i++) {
                        if ($array[$i]['qtd_votos'] != null && $array[$i]['num_zona'] != null) {
                          echo "<tr>"
                            . "<td>" . $array[$i]['qtd_votos'] . "</td>"
                            . "<td>" . $array[$i]['num_zona'] . "</td>"
                            . "</tr>";
                        }
                      }
                      ?>
                    </tbody>

                  </table>
                </div>
              </center>

            <?php

            for ($i = 0; $i < $cont; $i++) {
              if ($array[$i]['qtd_votos'] != null && $array[$i]['num_zona'] != null) {
                $votos[$i] = $array[$i]['qtd_votos'];
                $cands[$i] = $array[$i]['num_zona'];
              }
            }
          }

            ?>



            </center>

            <script>
              var cont = <?= json_encode($cont); ?>;
              <?php $cont = 0 ?>;



              votos = <?= json_encode($votos); ?>;
              cands = <?= json_encode($cands); ?>;
            </script>

            <br>
            <script>
              // ============================================
              // Bibiloteca Chart.js v2.5.0
              // dcumentacao http://www.chartjs.org/docs
              // ============================================
             

              var chart = document.getElementById('chart').getContext('2d'),
                gradient = chart.createLinearGradient(0, 0, 0, 450);

              var data = {
                labels: cands,
                datasets: [{
                  label: 'Quantidades de Eleitores',
                  backgroundColor: gradient,
                  pointBackgroundColor: 'goldenrod',
                  borderWidth: 1,
                  borderColor: 'orange',
                  data: votos
                }]
              };


              var options = {
                responsive: true,
                maintainAspectRatio: true,
                animation: {
                  easing: 'easeInOutQuad',
                  duration: 520
                },
                scales: {
                  xAxes: [{
                    gridLines: {
                      color: 'rgba(33, 32, 32, 0.97)',
                      lineWidth: 1
                    }
                  }],
                  yAxes: [{
                    gridLines: {
                      color: 'rgba(33, 32, 32, 0.97)',
                      lineWidth: 1
                    }
                  }]
                },
                elements: {
                  line: {
                    tension: 0.3
                  }
                },
                legend: {
                  display: false
                },
                point: {
                  backgroundColor: 'white'
                },
                tooltips: {
                  titleFontFamily: 'Open Sans',
                  backgroundColor: 'rgba(0,0,0,0.3)',
                  titleFontColor: 'white',
                  caretSize: 5,
                  cornerRadius: 2,
                  xPadding: 10,
                  yPadding: 10
                }
              };


              var chartInstance = new Chart(chart, {
                type: 'line',
                data: data,
                options: options
              });



              $(document).ready(function() {
                $('#tabela').DataTable({
                  dom: 'Bfrtip',
                  "order": [
                    [0, 'asc'],
                    [1, 'asc'],
                    [2, 'asc'],
                    [3, 'asc'],
                    [4, 'asc'],
                    [5, 'asc']
                  ],
                  "bSort": false,
                  buttons: [
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                  ],
                  "language": {
                    "lengthMenu": "Mostrar _MENU_ linhas",
                    "zeroRecords": "Nada Encontrado ;-;",
                    "info": "Pagina _PAGE_ de _PAGES_",
                    "search": "Pesquisa:",
                    "infoEmpty": "Nenhum resultado encontrado",
                    "infoFiltered": "(use o filtro novamente)",
                    "paginate": {
                      "first": "Primeiro",
                      "last": "Ultimo",
                      "next": "Proximo",
                      "previous": "Antes"
                    }
                  }
                });
              });
            </script>

          <?php
        } else if (@$_REQUEST['ano'] == "2020") {

          ?>
            <br>
            <br>
            <br>
            <h1 style="color:white;">Lamento mas é muito cedo para isso ;)</h1>
          <?php

        } else {
          ?>
            <br>
            <br>
            <br>
            <h1 style="color:white;">Selecione uma opção para visualizar</h1>
          <?php
        }
          ?>

          <script>

          </script>


  </div>


</body>

</html>