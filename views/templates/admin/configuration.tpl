{if $output !=null}
<div class="alert alert-success" role="alert">
  <p class="alert-text">
   {$output}
  </p>
</div>

{else}
<div class="alert alert-danger" role="alert">
  <p class="alert-text">{$exceptonmessage}</p>
  <ul>
    <li>One thing</li>
    <li>Another thing</li>
  </ul>
</div>
   
{/if}


<form action="" method="post">
 
<div class="form-group">
  <label class="form-control-label" for="input1">Normal input</label>
  <input type="text" name="courserating" class="form-control" value="{$output}" id="input1" required="required" />
</div>
<div class="form-group">
  <button type="submit" class="btn btn-primary">ZATWIERDŹ</button>
</div>
</form>