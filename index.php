<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simulador de Remuneração Variavel</title>
	<link href="css/bootstrap-4.0.0.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">

<?php 


$ranking;
$salario = filter_input(INPUT_POST,'salario', FILTER_SANITIZE_STRING);
$valor = filter_input(INPUT_POST,'valor_venda', FILTER_SANITIZE_NUMBER_INT);

function GetCalConversao($conversao = null){
  $conversao = filter_input(INPUT_POST, 'conversao', FILTER_SANITIZE_NUMBER_INT);
  if($conversao >= 25){
    $conversao = 75;
  } 
  return $conversao;
}
function GetAdicional(){
	global $valor;
	if((!empty($valor) AND ($valor) >= 81000)){
      $addvalor = 100;
	} else {
	  $addvalor = 0;
  }
	return $addvalor;
}

function GetSalario(){
	global $salario;
	$money = str_replace(',', '.', $salario);
	return $money;
} 
function CalcularValorVenda($valor){
	global $ranking;
	$listaA = array('faixaInicial' => '64802', 'faixaFinal' => '81000');// RANKING 1
	$listaB = array('faixaInicial' => '56702', 'faixaFinal' => '64800');// RANKING 2
	$listaC = array('faixaInicial' => '48602', 'faixaFinal' => '56700');// RANKING 3
	$listaD = array('faixaInicial' => '32402', 'faixaFinal' => '48600');// RANKING 4
	$listaE = array('faixaInicial' => '24302', 'faixaFinal' => '32400');// RANKING 5
	$listaF = array('faixaInicial' => '0', 'faixaFinal' => '24300');    // RANKING 6

        if(($valor >= $listaA['faixaInicial']) && ($valor <= $listaA['faixaFinal'])){
            $ranking = 1;
        } elseif(($valor >= $listaB['faixaInicial'])  && ($valor <= $listaB['faixaFinal'])){
            $ranking = 2;
        } elseif(($valor >= $listaC['faixaInicial'])  && ($valor <= $listaC['faixaFinal'])){
            $ranking = 3;
        } elseif(($valor >= $listaD['faixaInicial'])  && ($valor <= $listaD['faixaFinal'])){
            $ranking = 4;
        } elseif(($valor >= $listaE['faixaInicial'])  && ($valor <= $listaE['faixaFinal'])){
            $ranking = 5;
        } elseif(($valor >= $listaF['faixaInicial'])  && ($valor <= $listaF['faixaFinal'])){
            $ranking = 6;
        } 
        else {
           $ranking = "Nenhuma faixa de ranking foi atribuida"; 
        }
   return $ranking;

	
} $quantia = CalcularValorVenda($valor);

function CalcularQualidade(){
	global $quantia;
	global $comissao;

    $qualidade = filter_input(INPUT_POST,'qualidade', FILTER_SANITIZE_STRING);
   	$quali = str_replace(',', '.', $qualidade);
	switch ($quantia) {
		case '1':
			if($quali >= 85){
               $comissao = 585;
	        } if(($quali >= 50.0) && ($quali <= 84.9)){
               $comissao = 292.50;
	        } 
	        if(($quali >= 49.9) && ($quali < 50.0)){
              $comissao = 146.25;
	        }
			break;
		case '2':
		    if($quali >= 85){
               $comissao = 322;
	        } if(($quali >= 50.0) && ($quali <= 84.9)){
               $comissao = 161;
	        } if(($quali >= 49.9) && ($quali < 50.0)){
              $comissao = 80.50;
	        }
			break;
		case '3':
			if($quali >= 85){
               $comissao = 201;
	        } if(($quali >= 50.0)  && ($quali <= 84.9)){
               $comissao = 100.63;
	        } if(($quali >= 49.9) && ($quali < 50.0)){
              $comissao = 50.31;
	        }
	        break;
	    case '4':
	    	if($quali >= 85){
               $comissao = 132;
	        } if(($quali >= 50.0) && ($quali <= 84.9)){
               $comissao = 66;
	        } if(($quali >= 49.9) && ($quali < 50.0)){
              $comissao = 33;
	        }
			break;
		case '5':
	    	if($quali >= 85){
               $comissao = 44;
	        } if(($quali > 50.0) && ($quali <= 84.9)){
               $comissao = 22;
	        } if(($quali >= 49.9) && ($quali < 50.0)){
              $comissao = 11;
	        }
			break;
		case '6':
	    	if($quali >= 85){
               $comissao = 16.50;
	        } if(($quali >= 50.0) && ($quali <= 84.9)){
               $comissao = 8.25;
	        } if(($quali >= 49.9) && ($quali < 50.0)){
              $comissao = 4.13;
	        }
			break;

		default:		
	  break;


	}
     	  
	return $comissao;

}


function GetMostrarRanking(){
   $id = filter_input(INPUT_POST,'posicao',FILTER_SANITIZE_NUMBER_INT);
   $bonus;
   if(!empty($id)){
   	   if(($id >= 1) && ($id <= 5)){
      $bonus = 100;
      } else{
       $bonus = 50;
     }
       
     return $bonus;
   }
   
  
} //GetMostrarRanking();
function GetResultado(){
	$resultado = array(
		              CalcularQualidade(), 
		              GetSalario(),
		              GetMostrarRanking(),
		              GetAdicional(),
		              GetCalConversao($conversao = null)				  
	);
	$retorno = array_sum($resultado);
	return $retorno;
}   $valorTot = GetResultado();


?>
	
  </head>
	

  <body style="background-image: url('img/calculator.jpg');
	background-size: 100%;
    width: 100%;
    height: 800px;
    background-repeat: no-repeat;" >

   
	 
	  <div class="container-fluid" style="padding-left: 0px; padding-right:0px;">
		  <nav class="navbar navbar-default navbar-fixed-top" style="" >
			<div class="col-md-2 botoes ">
		    <a  style="background-color: rgba(0,0,0,0.00);"  href="http://10.10.2.215:8080/drogaria_sp/logado.php" class="form-control   btn " ><span ><i class="glyphicon glyphicon-home"></i></span>   Voltar </a>
		    </div>   
		    
		</nav>
	  </div>
	 <!--  <div style="" class="container">
		 <div class="row">
			<div class="col-md-2">
			
			</div>
			<div class="col-md-8"><br>
				<h1 align="center" style="font-family: bebas; font-size: 56px; letter-spacing: 2px;  text-shadow: 2px 3px #333 ; color: orange; margin-top:80px;" >Simulador de Variavel </h1>
			
			</div>
			<div class="col-md-2">
				<img style="float: right; margin-top: 10px;" src="img/logo-flex-roxo.png" height="50px">
			</div>
		 </div><br>
		</div>  -->
	  <!-- </div> -->
	  
  	<!-- body code goes here -->


  	 <div style="" class="container" s>

	   <form method="POST" action="index.php" style="/*background: #bdb6b6*/; margin: 10% 20%;
	    background-color: #fff;
        box-shadow: 0 3px 3px 0 rgba(0,0,0,.1);
        padding: 50px 0 10px; opacity: 0.9;">

	   	 <div class="row">
			<div class="col-md-12"><br>
				<h1 align="center" style="font-family: bebas; font-size: 35px; letter-spacing: 2px;  text-shadow: 2px 0px #333 ; color: orange; font-weight: 900;  " >Simulador de Variavel </h1>
			
			</div>
		
		 </div><br>
		 <div class="row">
		 	<div class="col-md-6 offset-md-3 col-xs-12 ">
			   <label><b>Salário Bruto</b></label>
			      <input type="text" class="form-control" name="salario" id="salario" placeholder="xxx" value="" >
			   </div>
		   
            <div class="col-md-6 offset-md-3 col-xs-12">
            	 <label><b>Qualidade</b></label>
            </div>
              <div class="input-group col-md-6 offset-md-3">
  				<input type="text" class="form-control aderencia" maxlength="7" name="qualidade" id="qualidade" placeholder="xxx" value="" >
                  <div class="input-group-append">
                  <span class="input-group-text">%</span>
              </div>
            </div>




            <div class="col-md-6 offset-md-3">
            	 <label><b>Valor da Venda</b></label>
            </div>
              <div class="input-group col-md-6 offset-md-3">
  				<input type="text" class="form-control" name="valor_venda"  maxlength="6" id="valor_venda" placeholder="xxx" value="" >
                  <div class="input-group-append">
                  <span class="input-group-text">,00</span>
              </div>
            </div>

              
		<!-- 	<div class="col-md-6 offset-md-3">
			   <label><b>Valor da Venda</b></label>
			 	<input type="text" class="form-control" name="valor_venda"  maxlength="10" id="valor_venda" placeholder="xxx" value="" >
			</div> -->
			<!-- 
			<div class="col-md-6 offset-md-3">
				<label  ><b id="lbl_conversao" style="display: none;">Conversão</b></label>
			 <input type="text" class="form-control tempo" style="display: none;" name="conversao" id="conversao" placeholder="" value="" > 
			</div> 
 -->
			 <div class="col-md-6 offset-md-3">
            	 <label  ><b id="lbl_conversao" style="display: none;">Conversão</b></label>
            </div>
              <div class="input-group col-md-6 offset-md-3">
  				<input type="text" class="form-control tempo" style="display: none;" maxlength="4" name="conversao" id="conversao" placeholder="" value="" >
                  <div class="input-group-append">
                  <span id="porc" class="input-group-text" style="display: none;">%</span>
              </div>
            </div>

			<div class="col-md-6 offset-md-3">
			   <label><b id="ranking" style="display: none;">Ranking</b></label>
			 	<select class="form-control " name="posicao" id="posicao" style="display: none;">
			 		<option value="">Nenhum</option>
			 		<option value="1">1</option>
			 		<option value="2">2</option>
			 		<option value="3">3</option>
			 		<option value="4">4</option>
			 		<option value="5">5</option>
			 		<option value="6">6</option>
			 		<option value="7">7</option>
			 		<option value="8">8</option>
			 		<option value="9">9</option>
			 		<option value="10">10</option>
			 	</select>
			</div>
			
			 <div class="col-md-6 offset-md-3">
			   	<label><b> Total Salário</b></label>
			 	<input type="text" class="form-control " name="total" style=" padding: 1.375rem;" placeholder="xxx" value="<?php echo "R$ ". number_format($valorTot, 2, ',', '.'); ?>" >
			</div>
	      </div><br>
		

		 <div class="row">
		   <div class="col-md-6  offset-md-3">
			 <input type="submit" style="background-color: rgba(102,34,80,1.00); color: #FFF;  margin-bottom: 5px; padding: 12px;" class="form-control btn" value="calcular">
			  </div>
			<div class="col-md-6  offset-md-3">
			 	<p align="center">
			 		<a style="background-color: rgba(102,34,80,1.00); color: #FFF;  padding: 12px;"  href="index.php" class="form-control btn" onclick="confirmacao()" >Apagar</a> 
			 	</p>
			  </div>
		    </div>
	       <div class="row">
			<div class="col-md-12">
				<h1 style=" font-size:60px; text-shadow: 2px 3px #333 ; color: orange;"  align="center">
				</h1>
			</div>
		 </div>
		</form>  
	  </div>
  	 	


	 
	
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="js/jquery-3.2.1.min.js"></script>	
<script src="js/jquery.mask.min.js"></script>
<script>
      $("#valor_venda").change(function() {
          var elemento = $("#valor_venda").val();
           //alert(elemento);
           $("#valor_venda").blur(function(){
           	//alert("perdeu  foco");
              var valor = 48600;
              if(elemento >= valor ){
          	     $('#conversao').css('display','block');
          	     $('#lbl_conversao').css('display','block');
          	     $('#porc').css('display','block');
          	     // $('#posicao').css('display','block');
          	     // $('#posicao').css('display','block');
              } 
           });
        });

        $("#valor_venda").change(function() {
        	var data = $("#valor_venda").val();
        	$("#valor_venda").blur(function(){
        		var lblValor = 81000;
        		if(data >= lblValor){
        	     $('#ranking').css('display','block');
        		 $('#posicao').css('display','block');
        		}

        	});
        });

</script>

<script>
  $(document).ready(function(){
  $('.tempo').mask('00:00:00');
  // $('#qualidade').mask('99,99%');
  $('#conversao').mask('99,99%');
		  
});
		   
</script> 	
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap-4.0.0.js"></script>
  </body>
</html>