<div class="register-container">
		<div id="register-result"></div>
		<div id="register-area">
		<div class="logo"></div>

		<form id="registerForm" action="#" method="post">
			<div>
				<p><label for="username" class="label">Kullanıcı adı:</label>
				<input id="username" placeholder="Kullanıcı adı..." name="username" maxlength="20" type="text" tabindex="1" class="input" /></p>

				<p><label for="password" class="label">Şifre:</label>
				<input id="password" placeholder="Şifre..." name="password" maxlength="20" type="password" tabindex="2" autocomplete="off" class="input"/></p>
				
				<p><label for="cpassword" class="label">Şifre (doğrula):</label>
				<input id="cpassword" placeholder="Şifre (doğrula)..." name="cpassword" maxlength="20" type="password" tabindex="2" autocomplete="off" class="input"/></p>
				
				<p><label for="email" class="label">Email:</label>
				<input id="email" placeholder="Email..." name="email" maxlength="70" type="text" tabindex="2" autocomplete="off" class="input"/></p>
				
				<p><label for="cemail" class="label">Email (doğrula):</label>
				<input id="cemail" placeholder="Email (doğrula)..." name="cemail" maxlength="70" type="text" tabindex="2" autocomplete="off" class="input"/></p>
				
				<p>
					<button id="doRegister" class="ui-button button1" type="submit"> 
						<span class="button-left">
							<span class="button-right">Kayıt Ol</span>
						</span>
					</button>
				</p>
			</div>

			<ul id="help-links">
			
				<li>
					Hesabınıza erişemiyor musunuz? <a id="switchForgotPasswordModal" href="#">Şifrenizi sıfırlayın</a>!
				</li>
				<li>
					Hesabınız var mı? <a id="switchLoginModal" href="#">Giriş yapın</a>!
				</li>
			</ul>
		</form>
	</div>
</div>