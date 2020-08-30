<form class="form-page" action="/registration" method="POST">
	<fieldset>
		<div class="form-group">
			<label>username</label>
			<input class="form-control" type="text" name="username" value="<?php echo isset($prev_values) ? $prev_values[0] : '';?>"/>
		</div>
		<div class="form-group">
			<label>e-mail</label>
			<input class="form-control" type="email" name="email" value="<?php echo isset($prev_values) ? $prev_values[1] : '';?>"/>
		</div>
		<div class="form-group">
		<label>password</label>
			<input class="form-control" type="password" name="pass"/>
		</div>
	</fieldset>
	<?php if(isset($messages)):?>
		<?php if($error == true):?>
			<div class="alert alert-dismissable alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Error!</strong>
				<?php for($i = 0; $i < count($messages); $i++):?>
					<div><?php echo ($i + 1) . ")" . $messages[$i]?></div>
				<?php endfor;?>
			</div>
		<?php endif;?>
	<?php endif;?>
	<input class="btn btn-primary" type="submit" name="confirm">
</form>