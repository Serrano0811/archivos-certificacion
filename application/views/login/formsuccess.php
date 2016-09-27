<div class="well">
	<h3>Estado del formulario: <span class="badge">success!</span></h3>
</div>

<div class="container">
	<h5>Nombre: <?php echo $nombre; ?></h5>
	<h5>Apellido Paterno: <?php echo $apellido_paterno; ?></h5>
	<h5>Apellido Materno: <?php echo $apellido_materno; ?></h5>
	<h5>Usuario: <?php echo $usuario; ?></h5>
	<h5>Email: <?php echo $email; ?></h5>
	<h5>Archivo *.CER: <?php echo $sello_cer; ?></h5>
	<h5>Archivo *.KEY: <?php echo $sello_key; ?></h5>
	<h5>Contrase&ntilde;a CER: <?php echo $password; ?></h5>
	<h5>RFC: <?php echo $RFC; ?></h5>
</div>

<div>
	<h3 class="despl-activador-cer">Archivo *.CER guardado exitosamente! <span></span></h3>
		<div class="despl-div-cer">
			<ul>
				<?php foreach ($sello_cer_upload['upload_data'] as $indice => $valor):?>
				<li><?php echo $indice;?>: <?php echo ($valor == '')?'No aplica':$valor;?></li>
				<?php endforeach; ?>
			</ul>
			<p>Resultado: upload: {<?php echo ($sello_cer_upload['resultado'] == 1)?'TRUE':'FALSE' ?>}</p>
		</div>
</div>

<div>
	<h3 class="despl-activador-key">Archivo *.KEY guardado exitosamente! <span></span></h3>
		<div class="despl-div-key">
			<ul>
				<?php foreach ($sello_key_upload['upload_data'] as $indice => $valor):?>
				<li><?php echo $indice;?>: <?php echo ($valor == '')?'No aplica':$valor;?></li>
				<?php endforeach; ?>
			</ul>
			<p>Resultado: upload: {<?php echo ($sello_key_upload['resultado'] == 1)?'TRUE':'FALSE' ?>}</p>
		</div>
</div>

<div>
	<p><?php foreach($_FILES as $file){
  			echo $file['name']; 
		} ?>
	</p>
</div>

<p><?php echo anchor('form', 'Volver al formulario!'); ?></p>