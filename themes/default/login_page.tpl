<div class="login-container">
		<div id="login-result"></div>
		<div id="login-area">
		<div class="logo"></div>

		<form id="loginForm" action="#" method="post">
			<div>
				<p><label for="username" class="label">Kullanıcı adı:</label>
				<input id="username" placeholder="Kullanıcı adı..." name="username" maxlength="20" type="text" tabindex="1" class="input" /></p>

				<p><label for="password" class="label">Şifre:</label>
				<input id="password" placeholder="Şifre..." name="password" maxlength="20" type="password" tabindex="2" autocomplete="off" class="input"/></p>

				<p>
					<button id="doLogin" class="ui-button button1" type="submit"> 
						<span class="button-left">
							<span class="button-right">Giriş Yap</span>
						</span>
					</button>
				</p>
			</div>

			<ul id="help-links">
			
				<li>
					Hesabınıza erişemiyor musunuz? <a id="switchForgotPasswordModal" href="#">Şifrenizi sıfırlayın</a>!
				</li>
				<li>
					Bir hesabınız yok mu? <a id="switchRegisterModal" href="#">Şimdi kayıt olun</a>!
				</li>
			</ul>
		</form>
	</div>
</div>