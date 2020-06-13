<?php
include 'database.php';




include 'Classes/QuickSort.class.php';



//include 'autoLoader.inc.php';
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="styles/geral.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
        <title>
            RoBR
        </title>
    </head>
    <body style="background-color: #252429">
        <style>
            a{
            text-decoration: none;
            z-index:200;
               }
             .background{
               background-color: #252429;
               height:100%;
               width: 100%;
             } 

.dropbtn {
  background-color:  #1f1e22;
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
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

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
             
        <div class="background">
        <div class="title-box">ROBR</div>
        <br>
            <h2  align="center" style="color:gray;font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Consultar Resultados</h2>
            <br>
           <center>
            <div class="dropdown">
             <button class="dropbtn">Vereador</button>
             <div class="dropdown-content">
             <a href="QuickSort.php?ano=2008&cargo=1">2008</a>
             <a href="QuickSort.php?ano=2012&cargo=1">2012</a>
             <a href="QuickSort.php?ano=2016&cargo=1">2016</a>
             <a href="QuickSort.php?ano=2020">2020</a>
               </div>
           </div>
             
            <div class="dropdown">
             <button class="dropbtn">Prefeito</button>
             <div class="dropdown-content">
             <a href="QuickSort.php?ano=2008&cargo=2">2008</a>
             <a href="QuickSort.php?ano=2012&cargo=2">2012</a>
             <a href="QuickSort.php?ano=2016&cargo=2">2016</a>
             <a href="QuickSort.php?ano=2020">2020</a>
               </div>
           </div>

            <div class="dropdown">
             <button class="dropbtn">Zona Eleitoral</button>
             <div class="dropdown-content">
             <a href="QuickSort.php?ano=2008&cargo=3">2008</a>
             <a href="QuickSort.php?ano=2012&cargo=3">2012</a>
             <a href="QuickSort.php?ano=2016&cargo=3">2016</a>
             <a href="QuickSort.php?ano=2020">2020</a>
               </div>
           </div>
            <div class="dropdown">
             <button class="dropbtn">Algoritimos</button>
             <div class="dropdown-content">
             <a  href="SelectionSort.php">SelectionSort</a>
             
             <a  href="InsertionSort.php">InsertionSort</a>
             <a  href="BubbleSort.php">BubbleSort</a>
             <a  href="SelectionSort.php">SelectionSort</a>
             <a  href="MergeSort.php">MergeSort</a>
             <a  href="consultas.php">Sem Ordenação</a>
               </div>
           </div>
           
           
       
          <!---<a href="main.php" class="input-1"> sair </a>--->
          <?php

          if(@$_REQUEST['ano'] != "2020" && @$_REQUEST['ano'] != null ){
          $ano = @$_REQUEST['ano'];
          
          
          
          $array;
          $votos;
          $cands;
          $cont = 0;
          

          if(@$_REQUEST['cargo'] == "1"){




    $query = "select id as qtd_votos,nome from candidato WHERE candidato.id_escolaridade != 1 AND cargo = 'VEREADOR' AND id_ano = (SELECT id FROM ano WHERE ano.desc_ano = '$ano')";

    $result = mysqli_query($conn,$query);
    
    
    while ($coluna=mysqli_fetch_array($result)) 
    {
    $array[$cont++] = $coluna;
    }
        
    
       
 

   }else if(@$_REQUEST['cargo'] == "2"){

    
    $query = "select id as qtd_votos,nome from candidato WHERE candidato.id_escolaridade != 1 AND cargo = 'PREFEITO' AND id_ano = (SELECT id FROM ano WHERE ano.desc_ano = '$ano')";

    $result = mysqli_query($conn,$query);
    
    
    while ($coluna=mysqli_fetch_array($result)) 
    {
    $array[$cont++] = $coluna;
    }





      }else if(@$_REQUEST['cargo'] == "3"){


    $query = "SELECT z.num_zona,b.nome, concat('N°',z.num_zona , ' - ', b.nome)as nome, sum(vot.qtd_votos)as qtd_votos  FROM zona z inner join bairro b on z.id_bairro = b.id inner join votacao_zona_secao vot on z.id = vot.id_zona inner join ano ano on ano.id = vot.id_ano where ano.desc_ano = '$ano' group by z.num_zona,b.nome";

    $result = mysqli_query($conn,$query);
    
    
    while ($coluna=mysqli_fetch_array($result)) 
    {
    $array[$cont++] = $coluna;
    }

 


}

    
    
     

    

   // $mt = explode(' ', microtime());
  //$start = ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));

   $start = microtime(true);


    $array = quickSort($array,0,count($array) - 1);
    
    // $mt = explode(' ', microtime());
     //$end = ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));
     //$array['QuickSort']["tempo"] = 'Tempo de execução '.($end - $start).' milisegundos'; 
    $array['QuickSort']["tempo"] = 'Tempo de execução '.(number_format((microtime(true) - $start),4)).' segundos';
    



    
    
    for($i = 0 ; $i< $cont;$i++){
    if($array[$i]['qtd_votos'] != null && $array[$i]['nome'] != null){
    $votos[$i] = $array[$i]['qtd_votos'];
    $cands[$i] = $array[$i]['nome'];
    }
       }

     
     
    

     echo "<p style='color:white;'>Algoritimo Quick Sort</p>";
     echo "<p style='color:white;'>".$array['QuickSort']["tempo"]."</p>";

    
 

    
?>
    <script>
        var cont = <?= json_encode($cont);?>;
        <?php $cont = 0?>;
         
        

        votos = <?= json_encode($votos);?> ;
        cands = <?= json_encode($cands);?> ;
      

    </script> 
  
<br><br><br>
<div class="line-chart">
            <div class="aspect-ratio">
                    <canvas id="chart"></canvas>
            </div>
        </div>

      


       

             


        
        <br>
    <script>
        // ============================================
// Bibiloteca Chart.js v2.5.0
// dcumentacao http://www.chartjs.org/docs
// ============================================

var chart    = document.getElementById('chart').getContext('2d'),
    gradient = chart.createLinearGradient(0, 0, 0, 450);

var data  = {
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

</script>

    <?php
} else if(@$_REQUEST['ano'] == "2020"){
    
?>
<br>
<br>
<br>
<h1 style="color:white;">Lamento mas é muito cedo para isso ;)</h1>
<?php

}else{
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

</center>
         </div>
        
    </body>
</html>