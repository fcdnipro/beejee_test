<form class="form-page" method="POST" enctype="multipart/form-data" id="createForm">
	<?php if(!isset($_SESSION['username'])):?>
		<div class="form-group">
			<label>username</label>
			<input class="form-control" type="text" name="username" value="<?php echo isset($prev_values) ? $prev_values[0] : '';?>" id="usernameData"/>
		</div>
	<?php endif;?>
	<div class="form-group">
		<label>text</label>
		<textarea class="form-control" type="text" name="text" id="textData"><?php echo isset($prev_values) ? $prev_values[1] : '';?></textarea>
	</div>
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
	<input class="btn btn-primary" type="submit" name="confirm"/>
	<input class="btn btn-primary" type="button" name="preview" value="Preview" id="previewTask"/>
</form>
<div id="previewForm" style="height: 0;"></div>
<div class="card border-danger mb-3" id="previewBlock" style="display: none;">
	<div class="card-header">
		<div>Username: <span id="username"></span></div>
		<div>E-mail: <span id="email"></span></div>
	</div>
	<div class="card-body">
		<div class="card-text">
			<div><span id="text"></span></div>
			<input type="checkbox" class="checkbox-status" disabled/>
		</div>
	</div>
</div>
</div>
