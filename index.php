<?php
date_default_timezone_set("America/Sao_Paulo"); 
?>
<!--doctype html-->
<html>
	<head>
		<meta charset="utf8" />
		<title>Renomar imagens - EMAIL MARKETING</title>
		<link rel="shortcut icon" href="icon.png" />
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,400,700" />
		<style>
			 body{ background: #f6f6f6; font-family: 'Source Sans Pro'; text-align: center; margin-top: 20%; }
			 h1{ font-size: 19px; font-weight: 200; }
			 button, input[type="submit"]{ background: #8dc63f; border: 0; padding: 10px; color: #FFF; border-bottom: 3px solid #7eb138; margin-right: 5px; cursor: pointer; }
			 button{ clear: both; }
			 small{ text-transform: uppercase; font-size: 14px; font-weight: 400; }
			 input[type="text"]{ border: 1px solid #ccc; padding: 10px; }
			 input[type="submit"]{ width: 20%; padding: 15px; display: none; }
			 .j2{ display: none; }
		</style>
	</head>
	<body>
		<img src="logo.png" />
		<h1>Renomear imagens - EMAIL MARKETING</h1>
		<?php

		$Dir = "c:/mkt";

		if(!file_exists($Dir)):
			mkdir($Dir);
		endif;

		$Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		if($Dados):
			$Imagens = $_FILES['imgs'];
			if($Dados['nfiles'] <= 0):
				echo '<p style="color: #b13838;">Selecione pelo menos 1 imagem.</p>';
			else:
				//echo '<pre>';
				//var_dump($Dados);
				//var_dump($Imagens);

				$Cliente = $_POST['client'];

				$Ano = date('Y');
				$DiaMes = date('d') . '-' . date('m');

				if(!file_exists($Dir.'/'.$Cliente)): mkdir($Dir.'/'.$Cliente); endif;
				if(!file_exists($Dir.'/'.$Cliente.'/'.$Ano)): mkdir($Dir.'/'.$Cliente.'/'.$Ano); endif;
				if(!file_exists($Dir.'/'.$Cliente.'/'.$Ano.'/'.$DiaMes)): mkdir($Dir.'/'.$Cliente.'/'.$Ano.'/'.$DiaMes); endif;
				if(!file_exists($Dir.'/'.$Cliente.'/'.$Ano.'/'.$DiaMes.'/imagens')): mkdir($Dir.'/'.$Cliente.'/'.$Ano.'/'.$DiaMes.'/imagens'); endif;

				$Path = "banner";
				$cArq = 1;

				for($i = 0; $i < count($Imagens['name']); $i++):
					//$NomeImgL = $Path.($i+1)."l";
					//echo "Renomear => " . $Imagens['name'][$i] . " para => " . $Path.($cArq)."l";
					//echo "Renomear => " . $Imagens['name'][$i+1] . " para => " . $Path.($cArq)."r";

					@move_uploaded_file($Imagens['tmp_name'][$i], $Dir.'/'.$Cliente.'/'.$Ano.'/'.$DiaMes.'/imagens/'.$Path.($cArq)."l.jpg");
					@move_uploaded_file($Imagens['tmp_name'][$i+1], $Dir.'/'.$Cliente.'/'.$Ano.'/'.$DiaMes.'/imagens/'.$Path.($cArq)."r.jpg");

					$i+=1;
					$cArq+=1;

				endfor;

				echo '<p style="color: #8dc63f;">Imagens renomeadas!<br/><strong>'.$Dir.'/'.$Cliente.'/'.$Ano.'/'.$DiaMes.'/imagens</strong></p>';
			endif;
		endif;
		?>

		<form method="post" action="" enctype="multipart/form-data">
			<label style="display: none;">
				<span>Imagens:</span>
				<input type="file" name="imgs[]" multiple accept="image/*" />
			</label>

			<input type="hidden" name="nfiles" value="0" />

			<p style="display: none;" class="nfiles"></p>

			<div class="j1">
				<p>1° Selecione as imagens:</p>				
				<button name="fake" class="j_fake">Selecionar imagens</button>
			</div>

			<div class="j2">
				<p>2° Informe o nome do cliente:</p>
				<input name="client_text" type="text" />
				<button class="j_save_client">Salvar</button>
				<input type="hidden" name="client" value="" />		
			</div>

			<button name="open_paste" style="display:none;">Abrir pasta</button>

			<br/><input type="submit" name="enviar" value="LUZ !" />
		</form>
		<p><small>&copy; <i>Bruno Martins</i> <br/> 2015 - <?=date('Y')?></small></p>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script type="text/javascript">
			$(function(){

				$('.j_fake').click(function(){
					$('input[name="imgs[]"]').click();
					return false;
				});

				$('button[name="open_paste"]').click(function(){
					return false;
				});

				$('input[name="imgs[]"]').on("change", function(){  
					var numFiles = $(this).get(0).files.length
					$('input[name="nfiles"]').val(numFiles);
					$('.nfiles').html("<strong>"+numFiles+"</strong> imagens selecionadas.").fadeIn("fast");

					$(".j1").fadeOut("fast", function(){
						$(".j2").fadeIn("fast");
					});

				});

				$('.j_save_client').click(function(){
					if($('input[name="client_text"]').val() == ""){
						alert('Preencha o nome do cliente!');
					}else{
						$('input[name="client"]').val($('input[name="client_text"]').val());
						$(".j2").fadeOut("fast", function(){
							$('input[name="enviar"]').css({"margin-top": "-20px"});
							$('input[name="enviar"]').fadeIn("fast");
						});
					}
					return false;
				});

			});
		</script>
	</body>
</html>