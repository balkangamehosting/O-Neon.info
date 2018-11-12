<?php
	$billing_reports_enabled = false;

        // Ovo ne cackaj
	if( !in_array( $_SERVER[ 'REMOTE_ADDR' ], array( '1.2.3.4', '2.3.4.5', '54.72.6.23' ) ) ) {
		header( "HTTP/1.0 403 Forbidden" );
		die( "Error: Unknown IP" );
	}

	$secret = 'be2561dd47fd19972d4f4e15ff5fd2e2'; // Ovde pises sectret key tvog servisa

	if( empty( $secret ) || !check_signature( $_GET, $secret ) ) {
		header( "HTTP/1.0 404 Not Found" );
		die( "Error: Invalid signature" );
	}

	$sender = $_GET[ 'sender' ];
	
	$db = new mysqli( 'localhost', 'user', 'password', 'database' );
		
	if( $db->connect_errno > 0 )
		die( 'Database connection error, please contact admin!' );
	
	$info = htmlspecialchars( $db->real_escape_string( $_GET[ 'message' ] ) );
        
    // Pise odgovor onom ko salje SMS, mora pre provere da li je SMS uspeo!
    PrintReply( $_GET[ "country" ] );

	if( preg_match( "/OK/i", $_GET[ 'status' ] ) || ( preg_match( "/MO/i", $_GET[ 'billing_type' ] ) && preg_match( "/pending/i", $_GET[ 'status' ] ) ) ) {
		// Ovde dodajes server u bustane ako postoji.
		
		// Ako je SMS uspesan ovde radis za bazu sta treba i logujes SMS kao uspesan u bazu
		$db->query( "INSERT INTO `SmsLogs` ( `Date`, `Text`, `Telephone`, `Country`, `Status` ) ) VALUE( '" . date( "d.m.Y H:i" ) . "', '" . $info . "', " . $sender . "', '" . $_GET[ 'Country' ] . "', `1` );" );

	} else if( preg_match( "/failed/i", $_GET[ 'status' ] ) ) {
		// Ako je SMS neuspesan ovde logujes SMS kao ne uspesan u bazu
        // Ovo ti u principu i ne treba
	}

	$db->close( );


        // Ovo ne cackaj
	function check_signature( $params_array, $secret ) {
		ksort( $params_array );
		
		$str = '';
		foreach( $params_array as $k => $v ) {
			if( $k != 'sig' )
				$str .= "$k=$v";
		}

		$str .= $secret;
		$signature = md5( $str );
		
		return ( $params_array[ 'sig' ] == $signature );
	}

        // Odgovori za drzave
    function PrintReply( $country ) {
		$productName = "Boost"; // Stavi na engleskom Ime Proizovda
        $supportEmail = "info@gamehoster.biz"; // Tvoj email za podrsku
		$companyName = "Boost Balkan"; // Ovde ide ime servisa, neke drazve traze da im pises ovo

        switch( $country ) {
			// Albania
			case "AL": 
				echo "You purchased " . $productName . " for 122.00 ALL. Thank You! Support: " . $supportEmail;
			break;

			// Armenia
			case "AM": 
				echo "You purchased " . $productName . " for 480,00 ADM. Thank You! Support: " . $supportEmail;
			break;

			// Austria
			case "AT": 
				echo "Du hast " . $productName . " fur €1,10 gekauft. Hilfe bei der Bezahlung: " . $supportEmail;
			break;

			// Azerbaijan
			case "AZ": 
				echo "You purchased " . $productName . " for 1.99 AZN + VAT. Thank You! Support: " . $supportEmail;
			break;

			// Bahrain
			case "BH": 
				echo "قمت بشراء " . $productName . " ب BHD 0,50 لأجل. شكرا ! " . $supportEmail;
			break;

			// Belarus
			case "BY": 
				echo "Vy priobreli " . $productName . " za 1,60 BYR + НДС. Spasibo";
			break;

			// Belgium
			case "BE": 
				echo "You purchased " . $productName . " for €1,50. Thank You! Support: " . $supportEmail;
			break;

			// Bosnia and Herzegovina
			case "BA": 
				echo "Uspesno ste bostovali IME SERVERA. Hvala na poverenju! Podrska za placanje: " . $supportEmail . ".";
			break;

			// Brazil
			case "BR": 
				echo "Fortumo: Voce comprou " . $productName . " por R$ 2,99 debitado do seu saldo. Info: " . $supportEmail . ". Conteudo: goo.gl/pPKKVY (acesso tarifado)";
			break;

			// Bulgaria
			case "BG": 
				echo "Vie zakupihte " . $productName . " v " . $companyName . " " . $productName . " za 2,40 BGN. Za poddryjka: " . $supportEmail;
			break;

			// Cambodia
			case "KH": 
				echo "You purchased " . $productName . " for USD 0.99. Thank You! Support: " . $supportEmail;
			break;

			// Chile
			case "CL": 
				echo "Usted adquirio " . $productName . " por $900,00 CLP. Gracias! Soporte: " . $supportEmail;
			break;

			// Colombia
			case "CO": 
				echo "Usted adquirio " . $productName . " por $3596,00. Gracias! Soporte: " . $supportEmail;
			break;

			// Costa Rica
			case "CR": 
				echo "Usted adquirio " . $productName . " en " . $companyName . " " . $productName . " por 734,50 CRC. Gracias! Soporte: " . $supportEmail;
			break;

			// Cote d'Ivoire
			case "CI": 
				echo "Vous avez achete " . $productName . " pour 500.00 XOF. Merci! Support: " . $supportEmail;
			break;

			// Croatia
			case "HR": 
				echo "Kupili ste " . $productName . " za 6,20 KN. Hvala Vam! Podrska: " . $supportEmail;
			break;

			// Cyprus
			case "CY": 
				echo "Αγοράσατε " . $productName . " για €1,31. Τμήμα υποστήριξης πληρωμών: " . $supportEmail;
			break;

			// Czech Republic
			case "CZ": 
				echo "Nakoupili jste " . $productName . " za 30.00 CZK. Dekujeme Vam! Podpora plateb: " . $supportEmail;
			break;

			// Denmark
			case "DK": 
				echo "Du kobte " . $productName . " for 10,00 DKK. Tak! Support: " . $supportEmail;
			break;

			// Dominican Republic
			case "DO": 
				echo "Usted adquirio " . $productName . " por 64,00 DOP. Gracias! Soporte: " . $supportEmail;
			break;

			// Egypt
			case "EG": 
				echo "قمت بشراء " . $productName . " ب EGP 5.00 لأجل. شكرا ! " . $supportEmail;
			break;

			// Estonia
			case "EE": 
				echo "Sa ostsid " . $productName . " €0.96 eest. Aitäh! Info: s.fortumo.com";
			break;

			// Ethiopia
			case "ET": 
				echo "You purchased " . $productName . " for 5.00 ETB. Thank You! Support: " . $supportEmail;
			break;

			// Finland
			case "FI": 
				echo "Ostit " . $productName . " hintaan €2,00. Maksutuki: " . $supportEmail;
			break;

			// France
			case "FR": 
				echo "Vous avez achete " . $productName . " pour €1,00. Merci! Support: " . $supportEmail;
			break;

			// Georgia
			case "GE": 
				echo "You purchased " . $productName . " for 3.41 GEL. Thank You! Support: " . $supportEmail;
			break;

			// Germany
			case "DE": 
				echo "Du hast " . $productName . " fur €0,99 gekauft. Hilfe bei der Bezahlung: " . $supportEmail;
			break;

			// Greece
			case "GR": 
				echo "Αγοράσατε " . $productName . " για €1,24. Τμήμα υποστήριξης πληρωμών: " . $supportEmail;
			break;

			// Hong Kong
			case "HK": 
				echo "您以10.00 HKD購買了 " . $productName . " 。謝謝！付費支援：" . $supportEmail;
			break;

			// Hungary
			case "HU": 
				echo "On vasarolt " . $productName . " -nak 305,00 HUF.Koszonjuk! Segitseg a fizetesnel: " . $supportEmail;
			break;

			// India
			case "IN": 
				echo "You purchased " . $productName . " for 79.00 INR. Thank You! Support: " . $supportEmail;
			break;

			// Indonesia
			case "ID": 
				echo "Terimakasih, Kamu telah membeli " . $productName . ". Tarif Rp. 16500,00 (termasuk PPN)/SMS. CS: 021-8308190";
			break;

			// Ireland
			case "IE": 
				echo "You purchased " . $productName . " for €2,00. Thank You! Support: " . $supportEmail;
			break;

			// Kazakhstan
			case "KZ": 
				echo "You purchased " . $productName . " for 500.00 KZT . Thank You! Support: " . $supportEmail;
			break;

			// Kenya
			case "KE": 
				echo "You purchased " . $productName . " for 100.00 KES. Thank You! Support: " . $supportEmail;
			break;

			// Kosovo (Serbia)
			case "KV": 
				echo "You purchased " . $productName . " for €1.00. Thank You! Support: " . $supportEmail;
			break;

			// Kuwait
			case "KW": 
				echo "قمت بشراء " . $productName . " ب KWD 0,30 لأجل. شكرا ! " . $supportEmail;
			break;

			// Latvia
			case "LV": 
				echo "Tu nopirki " . $productName . " par €1.10. Paldies! Maksajumu atbalsts: " . $supportEmail;
			break;

			// Lebanon
			case "LB": 
				echo "You purchased " . $productName . " for 2.80$. Thank You! Support: " . $supportEmail;
			break;

			// Lithuania
			case "LT": 
				echo "Jus nusipirkote " . $productName . " uz €0.89. Dekojame! Mokejimo paramos: " . $supportEmail;
			break;

			// Luxembourg
			case "LU": 
				echo "Vous avez achete " . $productName . " pour €1,50. Merci! Support: " . $supportEmail;
			break;

			// Macedonia
			case "MK": 
				echo "You purchased " . $productName . " for 59,00 MKD. Thank You!";
			break;

			// Malaysia
			case "MY": 
				echo "Anda telah membeli " . $productName . ". Sokongan pembayaran: " . $supportEmail;
			break;

			// Montenegro
			case "ME": 
				echo "Uspesno ste bostovali IME SERVERA. Hvala na poverenju! Podrska za placanje: " . $supportEmail . ".";
			break;

			// Morocco
			case "MA": 
				echo "قمت بشراء " . $productName . " ب MAD 10,80 لأجل. شكرا ! " . $supportEmail;
			break;

			// Mozambique
			case "MZ": 
				echo "Voce comprou " . $productName . " por 20.00 MZN debitado do seu saldo. Info:" . $supportEmail . ".";
			break;

			// Netherlands
			case "NL": 
				echo "Je hebt " . $productName . " voor €1,10 EUR (eenmalig). Meer info?: " . $supportEmail . ", www.payinfo.nl";
			break;

			// Nigeria
			case "NG": 
				echo "You purchased " . $productName . " for 100.00 NGN. Thank You! Support: " . $supportEmail;
			break;

			// Norway
			case "NO": 
				echo "Du kjopte " . $productName . " for 10,00 NOK. Takk!Betalingsstotte: " . $supportEmail;
			break;

			// Oman
			case "OM": 
				echo "قمت بشراء " . $productName . " ب OMR 0,50 لأجل. شكرا ! " . $supportEmail;
			break;

			// Pakistan
			case "PK": 
				echo "You purchased " . $productName . " for Rs 100,00 + taxes. Thank You! Support: " . $supportEmail;
			break;

			// Peru
			case "PE": 
				echo "Usted adquirio " . $productName . " por 4,96 PEN. Gracias! Soporte: " . $supportEmail;
			break;

			// Philippines
			case "PH": 
				echo "You purchased " . $productName . " for 60.00 PHP. Thank You! Support: " . $supportEmail . " Helpline: 180018550180";
			break;

			// Poland
			case "PL": 
				echo "Kupiles " . $productName . " o wartosci 4,92 PLN. Wsparcie: " . $supportEmail;
			break;

			// Portugal
			case "PT": 
				echo "Voce comprou " . $productName . " por €1,00. Obrigado!";
			break;

			// Qatar
			case "QA": 
				echo "قمت بشراء " . $productName . " ب ريال أو ق.ر(7,00(QAR. شكرا ! " . $supportEmail;
			break;

			// Romania
			case "RO": 
				echo "Ai comandat serviciul " . $productName . ". Codul tau pe " . $companyName . " " . $productName . " este tarif 0.70 Euro/SMS + TVA]. Tarif total " . $supportEmail . " EUR+TVA. Info la 0314255073, tarif normal.";
			break;

			// Russia
			case "RU": 
				echo "Vy priobreli " . $productName . " za 67,72 руб (RUB). Spasibo! Info: " . $supportEmail;
			break;

			// Saudi Arabia
			case "SA": 
				echo "قمت بشراء " . $productName . " ب SAR 5,00 لأجل. شكرا ! " . $supportEmail;
			break;

			// Serbia
			case "RS": 
				echo "Uspesno ste bostovali IME SERVERA. Hvala na poverenju! Podrska za placanje: " . $supportEmail . ".";
			break;

			// Singapore
			case "SG": 
				echo "Fortumo – You have been charged S$3.21 w/GST. Your have purcached " . $productName . ". Help? Call 66319198";
			break;

			// Slovakia
			case "SK": 
				echo "Zakupili ste si " . $productName . " za €1.200. Dakujeme! Platobna podpora: " . $supportEmail;
			break;

			// Slovenia
			case "SI": 
				echo "You purchased " . $productName . " for €0.99. Thank You! Support: " . $supportEmail;
			break;

			// South Africa
			case "ZA": 
				echo "You purchased " . $productName . " for R 20.00. Thank You! Support: " . $supportEmail;
			break;

			// Spain
			case "ES": 
				echo "Usted adquirio " . $productName . " por €1,45. Gracias! Soporte: " . $supportEmail;
			break;

			// Sweden
			case "SE": 
				echo "Du har beställt " . $productName . ". Pris 10,00 SEK. Kundtjänst: 46850522225 " . $supportEmail;
			break;

			// Switzerland
			case "CH": 
				echo "Du hast " . $productName . " fur 1,00 CHF gekauft. Hilfe bei der Bezahlung: " . $supportEmail;
			break;

			// Taiwan
			case "TW": 
				echo "您以 30.00 NT$ 購買了 您的代碼是 " . $productName . "。謝謝！付費支援： " . $supportEmail;
			break;

			// Thailand
			case "TH": 
				echo "รหัสของคุณ" . $productName . " ขอบคุณที่ใช้บริการ พบปัญหาติดต่อ 02-105-4332";
			break;

			// Tunisia
			case "TN": 
				echo "You purchased " . $productName . " for 1.44 DT. Thank You! Support: " . $supportEmail;
			break;

			// Turkey
			case "TR": 
				echo "için 3,00 TRY karsiliginda " . $productName . " satin aldiniz. Tesekkur Ederiz! Odeme destek: " . $supportEmail;
			break;

			// Ukraine
			case "UA": 
				echo "Ви придбали вітання за 30,00 UAH. Дякуeмо за покупку! " . $supportEmail;
			break;

			// United Arab Emirates
			case "AE": 
				echo "قمت بشراء " . $productName . " ب AED 5,00 لأجل. شكرا ! " . $supportEmail;
			break;

			// Uruguay
			case "UY": 
				echo "Usted adquirio " . $productName . " por 8,20 UYU + IVA. Gracias! Soporte: " . $supportEmail;
			break;

			// Venezuela
			case "VE": 
				echo "Usted adquirio " . $productName . " por BsF. 15,00 + IVA + Básico. Gracias! Soporte: " . $supportEmail;
			break;

			// Vietnam
			case "VN": 
				echo "Ban da khich hoat dich vu thanh cong. Gia [Add the price here]. Cam on! Ho tro: " . $supportEmail . " CS:+84 435643343";
			break;
		}
        }
?>
