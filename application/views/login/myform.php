<div class="jumbotron">	

	<?php echo form_open_multipart('form'); ?>

	<h5>Nombre:</h5>
	<?php echo form_error('nombre'); ?>
	<input type="text" name="nombre" value="<?php echo set_value('nombre'); ?>" size="50" />

	<h5>Apellido paterno:</h5>
	<?php echo form_error('apellido_paterno'); ?>
	<input type="text" name="apellido_paterno" value="<?php echo set_value('apellido_paterno'); ?>" size="50" />

	<h5>Apellido materno:</h5>
	<?php echo form_error('apellido_materno'); ?>
	<input type="text" name="apellido_materno" value="<?php echo set_value('apellido_materno'); ?>" size="50" />

	<h5>Usuario:</h5>
	<?php echo form_error('usuario'); ?>
	<input type="text" name="usuario" value="<?php echo set_value('usuario'); ?>" size="50" />

	<h5>Email:</h5>
	<?php echo form_error('email'); ?>
	<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="50" />

	<h5>Confirmaci&oacute;n de Email:</h5>
	<?php echo form_error('emailconf'); ?>
	<input type="text" name="emailconf" value="<?php echo set_value('emailconf'); ?>" size="50" />

	<h5>Archivo *.cer:</h5>
	<?php echo form_error('sello_cer'); ?>
	<input type="file" name="sello_cer" size="50" />

	<h5>Archivo *.key:</h5>
	<?php echo form_error('sello_key'); ?>
	<input type="file" name="sello_key" size="50" />

	<h5>Contrase&ntilde;a del certificado:</h5>
	<?php echo form_error('password'); ?>
	<input type="text" name="password" value="<?php echo set_value('password'); ?>" size="50" />

	<h5>RFC:</h5>
	<?php echo form_error('RFC'); ?>
	<input type="text" name="RFC" value="<?php echo set_value('RFC'); ?>" size="50" />

	<div><input type="submit" value="Submit" /></div>
<!--<?php echo validation_errors(); ?>-->
	</form>

</div>