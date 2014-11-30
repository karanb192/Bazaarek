{if isset($toast)}<div class="bootstrap">
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			{$toast}
		</div>
	</div>{/if}
<form  method="post" action="">
		<label>Name </label><br>
			<input name= "first" maxlength="255" size="11" value="{$first}"/>
			<input name= "last"  maxlength="255" size="11" value="{$last}"/>
		<br><label>Email </label><br>
			<input name="email" type="text" maxlength="255" value="{$email}"/> 

		<br><label>Message </label><br>
			<textarea name="message" >{$message}</textarea> 

			<br><input type="submit" name="submit" value="Submit" />
		</form>	