<?php
	
	if (!defined('ARISTONA') || ARISTONA != 1)
		die();
		
	define('E_MAIL_ADDR', $this->config['SITE']['E_MAIL']);

	class Page
	{
		private $site, $database, $content, $replace;
		private $cacheable = FALSE;
		private $cacheTime = 0;
		private $type = 'HTML';
		
		function __construct($site)
		{
			$this->site = $site;
			$this->config = $site->config;
			$this->database = $site->database;
			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_CONTACT_TITLE'));
		}

		function Run()
		{
			if (!isset($_POST['submit']))
			{
				$this->content = Template::Load('contact', array('HATA' => NULL));
			}
			else
			{
				$this->handleMail();
			}
		}
		
		function handleMail()
		{
			$isim 		= $_POST['contact_name'];
			$mail 		= $this->site->SanitizeEmail($_POST['contact_email'], 50);
			$tel 		= $_POST['tel'];
			$sirket 	= $this->site->SanitizeName($_POST['company'], 50) == NULL ? 'Şirket yok' : $this->site->SanitizeName($_POST['company'], 50);
			$lokasyon 	= $this->site->SanitizeName($_POST['location'], 30);
			$konu 		= $_POST['subject'];
			$mesaj 		= $_POST['message'];
			
			if (strlen($isim) > 50)
			{
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Bu kadar uzun bir isim & soyisim düşünülemiyor.'));
				return;
			}
			
			elseif (strlen($isim) <= 4)
			{
				
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Bu kadar kısa bir isim & soyisim düşünülemiyor.<br>İsmin uzunluğu (' . strlen($isim) . '), 5\'den
										  büyük veya eşit olmalıdır.'));
				return;
			}
			
			elseif (!preg_match("/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i", $mail))
			{
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Gerçersiz bir e-mail adresi girdiniz.<br>Sistem girdiğiniz e-maili doğrulayamadığı için kabul etmiyor. Lütfen e-maili doğru biçimde yazdığınızdan emin olunuz.'));
				return;
			}
			elseif (!is_numeric($tel) || $tel == NULL)
			{
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Telefon numarası nümerik bir değerde değil.'));
				return;
			}
			elseif (strlen($tel) != 10)
			{
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Telefon numarası 10 haneli olmalıdır!'));
				return;
			}
			elseif ($lokasyon == NULL)
			{
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Yanlış bir lokasyon (il) girdiniz.'));
				return;
			}
			elseif (strlen($konu) <= 3)
			{
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Mesaj konusu çok uzun yada çok kısa.<br>Mesaj konusu 3 ile 50 karakter arasında olmalıdır. Sizin konunuz (' . strlen($konu) . ') karakter uzunluğunda.'));
				return;
			}
			elseif ($mesaj == NULL)
			{
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Mesaj bölümü boş bırakılamaz.'));
				return;
			}
			else
			{
			$to      	= E_MAIL_ADDR;
			$subject 	= 'Siteden mail var!';
			$headers 	= 'From:' . $mail . "\r\n" .
					"MIME-Version: 1.0" . "\r\n" .
					"Content-type:text/html;charset=UTF-8" . "\r\n" .
					'Reply-To:' . $mail . "\r\n" .
					'X-Mailer: PHP/' . phpversion();
			$sonmesaj =
			'<p>Site İletişim Sayfası: ' . $isim . ' , size şu tarihte ' . date('Y-m-d g:i') . ' bir mail gönderdi.<br>
			Kişisel Bilgiler<br>Telefon No: ' . $tel .
			'<br>Lokasyon: ' . $lokasyon .
			'<br>Şirket: ' . $sirket .
			'<br>Mail Adresi: ' . $mail .
			'</p><p>Mail içeriği:</p><p> ' . $mesaj . '</p>';
			
			mail($to, $subject, $sonmesaj, $headers);
			if (@!mail) 
				$this->content = Template::Load('contact', array('HATA' => 'HATA! Mesaj gönderilemedi. Bu teknik bir sorundan kaynaklanıyor.')); 
			else
				$this->content = Template::Load('contact', array('HATA' => 'TEBRİKLER! Mesajınız gönderilmiştir.<br>Lütfen cevabımızı görmek için mail kutunuzu arasıra kontrol ediniz.<br><br>İlginiz için teşekkür ederiz.'));
			}	
		}

		function GetTemplate()
		{
			return $this->content;
		}
		
		function IsCacheable()
		{
			return $this->cacheable;
		}
		
		function CacheTime()
		{
			return $this->cacheTime;
		}
		
		function GetType()
		{
			return $this->type;
		}
		
		function __destruct()
		{
		}
	}
	
?>