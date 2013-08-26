<div id="navlist-loading">
	<div id="loading-area">
		
	</div>
</div>
<div id="navlist">
				<ul id="menu-main-nav" class="menu">
					<li><a href="<%SITE_ADDR%>#!">Anasayfa</a></li>
					
					<li><a href="http://www.sobafire.com/forum/" target="_blank">Forum</a></li>
					
					<li><a href="#">Öğren</a>
						<ul class="sub-menu">
							<li><a href="#">Şampiyon Buildleri</a>
								<ul class="sub-menu">
									<li><a href="<%SITE_ADDR%>#!team-sobafire-build-listesi.html">Team Sobafire Buildleri</a></li>
									<li><a href="<%SITE_ADDR%>#!profesyonel-oyuncu-build-listesi.html">Profesyonel Oyuncu Buildleri</a></li>
									<li><a href="<%SITE_ADDR%>#!build-listesi.html">Tüm Buildler</a></li>
								</ul>
							</li>
							<li><a href="#">Genel Rehberler</a>
								<ul class="sub-menu">
									<li><a href="#">Team Sobafire Rehberleri</a></li>
									<li><a href="#">Profesyonel Oyuncu Rehberleri</a></li>
									<li><a href="#">Tüm Rehberler</a></li>
								</ul>
							</li>
						</ul>
					</li>
					
					<li><a href="#">İzle</a>
						<ul class="sub-menu">
							<li><a href="<%SITE_ADDR%>#!livestream_listesi.html">Türk Oyuncuların Canlı Yayınları</a></li>
							<li><a href="<%SITE_ADDR%>#!video_listesi.html">Videolar</a></li>
						</ul>
					</li>
					
					<li><a href="#">E-Spor Alanı</a>
						<ul class="sub-menu">
							<li><a href="#">Turnuvalar</a>
								<ul class="sub-menu">
									<li><a href="<%SITE_ADDR%>#!tournament.html">Türkiye Sunucusundaki Turnuvalar</a></li>
									<li><a href="<%SITE_ADDR%>#!tournament.html">Ödüllü Turnuvalar</a></li>
									<li><a href="<%SITE_ADDR%>#!tournament.html">Tüm Turnuvalar</a></li>
								</ul>
							</li>
							
							<li><a href="#">Takımlar</a>
								<ul class="sub-menu">
									<li><a href="#">Profesyonel Takımları Listele</a></li>
									<li><a href="<%SITE_ADDR%>#!takim-listesi.html">Tüm Takımları Listele</a></li>
								</ul>
							</li>
							
							<li><a href="#">Oyuncular</a>
								<ul class="sub-menu">
									<li><a href="#">Profesyonel Oyuncuları Listele</a></li>
									<li><a href="<%SITE_ADDR%>#!oyuncu-listesi.html">Tüm Oyuncuları Listele</a></li>
								</ul>
							</li>
							
							<li><a href="#">Tanıtımlar</a>
								<ul class="sub-menu">
									<li><a href="#">Profesyonel Takımların Tanıtımları</a></li>
								</ul>
							</li>
					
						</ul>
					</li>
					
					<li><a href="#">SSS</a></li>
					
					<li><a href="#">Sobafire Ağı</a>
						<ul class="sub-menu">
							<li><a href="<%SITE_ADDR%>#!sobafire_nedir.html">Sobafire nedir?</a></li>
							<li><a href="<%SITE_ADDR%>#!sobafire_hakkimizda.html">Hakkımızda</a></li>
							<li><a href="<%SITE_ADDR%>#!sobafire_team.html">Team Sobafire</a></li>
							<li><a href="<%SITE_ADDR%>#!sobafire_sponsorluk.html">Sponsorluk</a></li>
							<li><a href="<%SITE_ADDR%>#!sobafire_bagis.html">Bağış</a></li>
							<li><a href="<%SITE_ADDR%>#!sobafire_api.html">Sobafire.com API</a></li>
							<li><a href="<%SITE_ADDR%>#!sobafire_iletisim.html">İletişim</a></li>
						</ul>
					</li>
					
					<li id="navigation-account"><%LOGIN_USERNAME%>					
						<ul class="sub-menu">
							<%ACCOUNT_MENU%>
						</ul>
					</li>
				</ul>	
</div>

<!-- modal login content -->
<div id="login-content" style="display:none;">
	<@LOGIN_PAGE@>
</div>

<!-- modal register content -->
<div id="register-content" style="display:none;">
	<@REGISTER@>
</div>

<!-- modal register success -->
<div id="register-success" style="display:none;">
	<h2>
	Başarı!
	<br><br>
	Kayıt işleminiz başarıyla yapıldı.
	<br><br>
	Artık giriş yapabilirsiniz! </h2>
</div>

<div id="logout-content" style="display:none;">
	<div class="logout-container">
		<h2>Gerçekten çıkış yapmak istiyor musun?</h2>
		<button id="doLogout" class="ui-button button1"> 
			<span class="button-left">
				<span class="button-right">Evet, çıkış yap</span>
			</span>
		</button>
	</div>
</div>