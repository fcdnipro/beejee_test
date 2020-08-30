<form class="form-page" action="/edit" method="POST" enctype="multipart/form-data">
	<?php if(!isset($_SESSION['username'])):?>
		<div class="form-group">
			<label>username</label>
			<input class="form-control" type="text" name="username"/>
		</div>
	<?php endif;?>
	<div class="form-group">
		<label>Text</label>
		<textarea class="form-control" type="text" name="text"><?php echo $text;?></textarea><br/>
	</div>
	<input type="hidden" name="taskId" value="<?php echo $taskId?>"/>
	<div class="form-group">
		<label class="form-check-label">
			<input class="form-check-input" type="checkbox" name="status" <?php echo $status == 1 ? 'checked' : ''?>/>
			Done
		</label>
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
	<input class="btn btn-primary" type="submit" name="confirm">
</form>