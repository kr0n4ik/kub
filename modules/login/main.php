<?php
?>
	<div id="js-pjax-container" data-pjax-container>
		<div class="auth-form px-3" id="login">
			<form accept-charset="UTF-8" action="/session" method="post">
				<div style="margin:0;padding:0;display:inline">
					<input name="utf8" type="hidden" value="&#x2713;" />
					<input name="authenticity_token" type="hidden" value="A2OzLxqqixemsIJxgFSlVwk7WTgDjOQEBlqNojt1eVFsj+1FpQ0lD7jeYbzgykHvP8IQQMdooCVwy/4ZETMdPA==" />
				</div>      
				<div class="auth-form-header p-0">
					<h1>Вход</h1>
				</div>

				<div id="js-flash-container">
					<div class="flash flash-full flash-error">
						<div class="container">
							<button class="flash-close js-flash-close" type="button" aria-label="Dismiss this message">
								<svg aria-hidden="true" class="octicon octicon-x" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path fill-rule="evenodd" d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"/></svg>
							</button>
							Неверный пароль или логин.
						</div>
					</div>
				</div>

				<div class="auth-form-body mt-3">
					<label for="login_field">
						Имя или e-mail
					</label>
					<input autocapitalize="off" autocorrect="off" class="form-control input-block" id="login_field" name="login" tabindex="1" type="text" value="" />
					<label for="password">
						Пароль <a href="/password_reset" class="label-link">Востановить пароль?</a>
					</label>
					<input autofocus="autofocus" class="form-control form-control input-block" id="password" name="password" tabindex="2" type="password" />

					<input class="btn btn-primary btn-block" data-disable-with="Signing in…" name="commit" tabindex="3" type="submit" value="Войти" />
				</div>
			</form>

			<p class="create-account-callout mt-3">
				Новичок?<a href="/join?source=login" data-ga-click="Sign in, switch to sign up">Создать профиль</a>.
			</p>
		</div>

	</div>