<?php
if ( !defined( "FILE_INDEX" ) ) { die( "Hacking..." ); exit(); }
?>
<div class="container">
	<div class="row">
        <div class="col-md-6">
            <form action="" method="post" id="fileForm" role="form">
            <fieldset>
				<legend class="text-center">
					Создание Вашего персонального сайта.
				</legend>

            <div class="form-group">
            <div class="form-group">
                <label for="email">E-mail адрес: </label> 
                <input class="form-control" required type="text" name="email" id = "email"  onchange="email_validate(this.value);" />   
                <div class="status" id="status"></div>
            </div>

            <div class="form-group">
                <label for="password">Пароль:</label>
                <input required name="password" type="password" class="form-control inputpass" minlength="4" maxlength="16"  id="pass1" /> </p>
            </div>

            <div class="form-group">
            
                <?php //$date_entered = date('m/d/Y H:i:s'); ?>
                <input type="hidden" value="<?php //echo $date_entered; ?>" name="dateregistered">
                <input type="hidden" value="0" name="activate" />
                <hr>

                <input type="checkbox" required name="terms" onchange="this.setCustomValidity(validity.valueMissing ? 'Please indicate that you accept the Terms and Conditions' : '');" id="field_terms">   <label for="terms">Я соглашаюсь с  <a href="terms.php" title="You may read our terms and conditions by clicking on this link">правилами пользования КУБом</a>.</label>
            </div>

            <div class="form-group">
                <input class="btn btn-success" type="submit" name="submit_reg" value="Регистрация">
            </div>
                      <h5>You will receive an email to complete the registration and validation process. </h5>
                      <h5>Be sure to check your spam folders. </h5>
 

            </fieldset>
            </form><!-- ends register form -->

        </div><!-- ends col-6 -->
		<div class="col-md-6">
			<fieldset>
				<legend class="text-center">
					Что Вам дает КУБ?
				</legend>
				<p>Перечесление плюшек</p>
                <p>Перечесление плюшек</p>
				<p>Перечесление плюшек</p>
				<p>Перечесление плюшек</p>
			</fieldset>
		</div>
	</div>
</div>