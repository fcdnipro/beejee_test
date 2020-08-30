<form action="#" method="GET" class="create-task">
	<select name="typeSort" class="custom-select sort-element">
		<option value="name" <?php if ($typeSort == 'name') {echo 'selected';}?>>Sort by name
		<option value="email" <?php if ($typeSort == 'email') {echo 'selected';}?>>Sort by e-mail
		<option value="status" <?php if ($typeSort == 'status') {echo 'selected';}?>>Sort by status
	</select>
    <select name="sortDirection" class="custom-select sort-element">
        <option value="asc" <?php if ($sortDirection == 'asc') {echo 'selected';}?>>ASC
        <option value="desc" <?php if ($sortDirection == 'desc') {echo 'selected';}?>>DESC
    </select>
	<input class="btn btn-primary sort-element" type="submit" name="confirm" value="Sort"/>
	<a href="/create" class="btn btn-primary sort-element">Create task</a>
</form>
<?php if(isset($_SESSION['messages'])):?>
	<div class="alert alert-dismissible alert-success">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Congratulations!</strong>
		<div><?php echo $_SESSION['messages'][0]; unset($_SESSION['messages']);?></div>
	</div>
<?php endif;?>
<?php foreach($dbData as $data):?>
	<div class="card border-danger mb-3">
		<div class="card-header">
			<div>Username: <?php echo $data['username'];?></div>
			<div>E-mail: <?php echo $data['email'];?></div>
		</div>
		<div class="card-body">
			<div class="card-text">
                <div><?php echo $data['text'];?></div>
				<input class="checkbox-status" type="checkbox" <?php echo $data['status'] == 1 ? 'checked' : ''?> disabled/>
			</div>
		</div>
		<form action="/edit" method="POST" class="edit-form">
			<input type="hidden" name="taskId" value="<?php echo $data['id']?>"/>
			<?php if(isset($_SESSION['admin_mode'])):?>
				<?php if($_SESSION['admin_mode'] == 'true'):?>
					<p class="lead"><input type="submit" name="confirm" value="Edit" class="btn btn-primary"/></p>
				<?php endif;?>
			<?php endif;?>
		</form>
	</div>
<?php endforeach;?>
<ul class="pagination paginator-align">
	<li class="page-item">
		<?php
            isset($_GET['p']) ? $page = $_GET['p'] : $page = 1;
		?>
		<a class="page-link" <?php echo ($page == 1) ? 'disabled' : ''?> href="<?php echo "?p=" . ($page - 1)?>">&laquo;</a>
	</li>
	<?php for($i = 1; $i <= $countPages; $i++):?>
		<li class="page-item">
			<a href="<?php echo "?p=" . $i . '&sortDirection=' . $sortDirection . '&typeSort=' . $typeSort?>" class="page-link" <?php echo ($i == $page) ? 'disabled' : ''?>><?php echo $i?></a>
		</li>
	<?php endfor;?>
	<li class="page-item">
		<a class="page-link" <?php echo ($page >= $countPages) ? 'disabled' : ''?> href="<?php echo "?p=" . ($page + 1)?>">&raquo;</a>
    </li>
</ul>