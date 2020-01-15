<?php
// ===== front vw start up theme plugin template ==========
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="container">
<div class="row">
  <form class="form-inline" action="" id="vw_form">
    <div class="col-sm-12 col-md-2">
      <label for="vw_phone">Телефон:</label>
	</div>
	<div class="col-sm-12 col-md-5">
        <input type="phone" class="form-control" id="vw_phone" placeholder="+7 (000) 000-00-00" name="vw_phone">
	</div>
    <div class="col-sm-12 col-md-5">
        <button id="vw_formSubmit" type="button" class="btn btn-default">Заказать</button>
	</div>
  </form>
</div>
</div>