<?php

add_action('init','of_options');

if( ! function_exists( 'of_options_array') )
{
	function of_options_array()
	{
		global $smof_data;

		// Avada edit
		//Register sidebar options for blog/portfolio/woocommerce category/archive pages
		global $wp_registered_sidebars;
		$sidebar_options[] = 'None';
		for($i=0;$i<1;$i++){
			$sidebars = $wp_registered_sidebars;// sidebar_generator::get_sidebars();
			//var_dump($sidebars);
			if(is_array($sidebars) && !empty($sidebars)){
				foreach($sidebars as $sidebar){
					$sidebar_options[] = $sidebar['name'];
				}
			}

			$sidebars = sidebar_generator::get_sidebars();
			if(is_array($sidebars) && !empty($sidebars)){
				foreach($sidebars as $key => $value){
					$sidebar_options[] = $value;
				}
			}
		}

		// End Avada edit


			// Begin Avada edit
			// Social Icon default order
			$of_options_social_links_ordering = array
			(
				  "default" => array (
						'facebook' => 'Facebook',
						'flickr' => 'Flickr',
						'rss' => 'RSS',
						'twitter' => 'Twitter',
						'vimeo' => 'Vimeo',
						'youtube' => 'Youtube',
						'instagram' => 'Instagram',
						'pinterest' => 'Pinerest',
						'tumblr' => 'Tumblr',
						'google' => 'Googleplus',
						'dribbble' => 'Dribble',
						'digg' => 'Digg',
						'linkedin' => 'LinkedIn',
						'blogger' => 'Blogger',
						'skype' => 'Skype',
						'forrst' => 'Forrst',
						'myspace' => 'Myspace',
						'deviantart' => 'Deviantart',
						'yahoo' => 'Yahoo',
						'reddit' => 'Reddit',
						'paypal' => 'Paypal',
						'dropbox' => 'Dropbox',
						'soundcloud' => 'Soundcloud',
						'vk' => 'VK',
				  ),
				  "custom" => array (
				  ),
			);
			// End Avada edit

			//More Options
			$body_repeat			= array(__("no-repeat", "Avada"),__("repeat-x", "Avada"),__("repeat-y", "Avada"),__("repeat", "Avada"));
			$body_pos			   = array(__("top left", "Avada"),__("top center", "Avada"),__("top right", "Avada"),__("center left", "Avada"),__("center center", "Avada"),__("center right", "Avada"),__("bottom left", "Avada"),__("bottom center", "Avada"),__("bottom right", "Avada"));


		/*-----------------------------------------------------------------------------------*/
		/* The Options Array */
		/*-----------------------------------------------------------------------------------*/

		// Set the Options Array
		$of_options = array();

		  // Avada Edit

		// Last updated: 2015/09/02
		$google_fonts = array (
			"None" => "None",
			"ABeeZee" => "ABeeZee",
			"Abel" => "Abel",
			"Abril Fatface" => "Abril Fatface",
			"Aclonica" => "Aclonica",
			"Acme" => "Acme",
			"Actor" => "Actor",
			"Adamina" => "Adamina",
			"Advent Pro" => "Advent Pro",
			"Aguafina Script" => "Aguafina Script",
			"Akronim" => "Akronim",
			"Aladin" => "Aladin",
			"Aldrich" => "Aldrich",
			"Alef" => "Alef",
			"Alegreya" => "Alegreya",
			"Alegreya SC" => "Alegreya SC",
			"Alegreya Sans" => "Alegreya Sans",
			"Alegreya Sans SC" => "Alegreya Sans SC",
			"Alex Brush" => "Alex Brush",
			"Alfa Slab One" => "Alfa Slab One",
			"Alice" => "Alice",
			"Alike" => "Alike",
			"Alike Angular" => "Alike Angular",
			"Allan" => "Allan",
			"Allerta" => "Allerta",
			"Allerta Stencil" => "Allerta Stencil",
			"Allura" => "Allura",
			"Almendra" => "Almendra",
			"Almendra Display" => "Almendra Display",
			"Almendra SC" => "Almendra SC",
			"Amarante" => "Amarante",
			"Amaranth" => "Amaranth",
			"Amatic SC" => "Amatic SC",
			"Amethysta" => "Amethysta",
			"Amiri" => "Amiri",
			"Amita" => "Amita",
			"Anaheim" => "Anaheim",
			"Andada" => "Andada",
			"Andika" => "Andika",
			"Angkor" => "Angkor",
			"Annie Use Your Telescope" => "Annie Use Your Telescope",
			"Anonymous Pro" => "Anonymous Pro",
			"Antic" => "Antic",
			"Antic Didone" => "Antic Didone",
			"Antic Slab" => "Antic Slab",
			"Anton" => "Anton",
			"Arapey" => "Arapey",
			"Arbutus" => "Arbutus",
			"Arbutus Slab" => "Arbutus Slab",
			"Architects Daughter" => "Architects Daughter",
			"Archivo Black" => "Archivo Black",
			"Archivo Narrow" => "Archivo Narrow",
			"Arimo" => "Arimo",
			"Arizonia" => "Arizonia",
			"Armata" => "Armata",
			"Artifika" => "Artifika",
			"Arvo" => "Arvo",
			"Arya" => "Arya",
			"Asap" => "Asap",
			"Asar" => "Asar",
			"Asset" => "Asset",
			"Astloch" => "Astloch",
			"Asul" => "Asul",
			"Atomic Age" => "Atomic Age",
			"Aubrey" => "Aubrey",
			"Audiowide" => "Audiowide",
			"Autour One" => "Autour One",
			"Average" => "Average",
			"Average Sans" => "Average Sans",
			"Averia Gruesa Libre" => "Averia Gruesa Libre",
			"Averia Libre" => "Averia Libre",
			"Averia Sans Libre" => "Averia Sans Libre",
			"Averia Serif Libre" => "Averia Serif Libre",
			"Bad Script" => "Bad Script",
			"Balthazar" => "Balthazar",
			"Bangers" => "Bangers",
			"Basic" => "Basic",
			"Battambang" => "Battambang",
			"Baumans" => "Baumans",
			"Bayon" => "Bayon",
			"Belgrano" => "Belgrano",
			"Belleza" => "Belleza",
			"BenchNine" => "BenchNine",
			"Bentham" => "Bentham",
			"Berkshire Swash" => "Berkshire Swash",
			"Bevan" => "Bevan",
			"Bigelow Rules" => "Bigelow Rules",
			"Bigshot One" => "Bigshot One",
			"Bilbo" => "Bilbo",
			"Bilbo Swash Caps" => "Bilbo Swash Caps",
			"Biryani" => "Biryani",
			"Bitter" => "Bitter",
			"Black Ops One" => "Black Ops One",
			"Bokor" => "Bokor",
			"Bonbon" => "Bonbon",
			"Boogaloo" => "Boogaloo",
			"Bowlby One" => "Bowlby One",
			"Bowlby One SC" => "Bowlby One SC",
			"Brawler" => "Brawler",
			"Bree Serif" => "Bree Serif",
			"Bubblegum Sans" => "Bubblegum Sans",
			"Bubbler One" => "Bubbler One",
			"Buda" => "Buda",
			"Buenard" => "Buenard",
			"Butcherman" => "Butcherman",
			"Butterfly Kids" => "Butterfly Kids",
			"Cabin" => "Cabin",
			"Cabin Condensed" => "Cabin Condensed",
			"Cabin Sketch" => "Cabin Sketch",
			"Caesar Dressing" => "Caesar Dressing",
			"Cagliostro" => "Cagliostro",
			"Calligraffitti" => "Calligraffitti",
			"Cambay" => "Cambay",
			"Cambo" => "Cambo",
			"Candal" => "Candal",
			"Cantarell" => "Cantarell",
			"Cantata One" => "Cantata One",
			"Cantora One" => "Cantora One",
			"Capriola" => "Capriola",
			"Cardo" => "Cardo",
			"Carme" => "Carme",
			"Carrois Gothic" => "Carrois Gothic",
			"Carrois Gothic SC" => "Carrois Gothic SC",
			"Carter One" => "Carter One",
			"Caudex" => "Caudex",
			"Cedarville Cursive" => "Cedarville Cursive",
			"Ceviche One" => "Ceviche One",
			"Changa One" => "Changa One",
			"Chango" => "Chango",
			"Chau Philomene One" => "Chau Philomene One",
			"Chela One" => "Chela One",
			"Chelsea Market" => "Chelsea Market",
			"Chenla" => "Chenla",
			"Cherry Cream Soda" => "Cherry Cream Soda",
			"Cherry Swash" => "Cherry Swash",
			"Chewy" => "Chewy",
			"Chicle" => "Chicle",
			"Chivo" => "Chivo",
			"Cinzel" => "Cinzel",
			"Cinzel Decorative" => "Cinzel Decorative",
			"Clicker Script" => "Clicker Script",
			"Coda" => "Coda",
			"Coda Caption" => "Coda Caption",
			"Codystar" => "Codystar",
			"Combo" => "Combo",
			"Comfortaa" => "Comfortaa",
			"Coming Soon" => "Coming Soon",
			"Concert One" => "Concert One",
			"Condiment" => "Condiment",
			"Content" => "Content",
			"Contrail One" => "Contrail One",
			"Convergence" => "Convergence",
			"Cookie" => "Cookie",
			"Copse" => "Copse",
			"Corben" => "Corben",
			"Courgette" => "Courgette",
			"Cousine" => "Cousine",
			"Coustard" => "Coustard",
			"Covered By Your Grace" => "Covered By Your Grace",
			"Crafty Girls" => "Crafty Girls",
			"Creepster" => "Creepster",
			"Crete Round" => "Crete Round",
			"Crimson Text" => "Crimson Text",
			"Croissant One" => "Croissant One",
			"Crushed" => "Crushed",
			"Cuprum" => "Cuprum",
			"Cutive" => "Cutive",
			"Cutive Mono" => "Cutive Mono",
			"Damion" => "Damion",
			"Dancing Script" => "Dancing Script",
			"Dangrek" => "Dangrek",
			"Dawning of a New Day" => "Dawning of a New Day",
			"Days One" => "Days One",
			"Dekko" => "Dekko",
			"Delius" => "Delius",
			"Delius Swash Caps" => "Delius Swash Caps",
			"Delius Unicase" => "Delius Unicase",
			"Della Respira" => "Della Respira",
			"Denk One" => "Denk One",
			"Devonshire" => "Devonshire",
			"Dhurjati" => "Dhurjati",
			"Didact Gothic" => "Didact Gothic",
			"Diplomata" => "Diplomata",
			"Diplomata SC" => "Diplomata SC",
			"Domine" => "Domine",
			"Donegal One" => "Donegal One",
			"Doppio One" => "Doppio One",
			"Dorsa" => "Dorsa",
			"Dosis" => "Dosis",
			"Dr Sugiyama" => "Dr Sugiyama",
			"Droid Sans" => "Droid Sans",
			"Droid Sans Mono" => "Droid Sans Mono",
			"Droid Serif" => "Droid Serif",
			"Duru Sans" => "Duru Sans",
			"Dynalight" => "Dynalight",
			"EB Garamond" => "EB Garamond",
			"Eagle Lake" => "Eagle Lake",
			"Eater" => "Eater",
			"Economica" => "Economica",
			"Eczar" => "Eczar",
			"Ek Mukta" => "Ek Mukta",
			"Electrolize" => "Electrolize",
			"Elsie" => "Elsie",
			"Elsie Swash Caps" => "Elsie Swash Caps",
			"Emblema One" => "Emblema One",
			"Emilys Candy" => "Emilys Candy",
			"Engagement" => "Engagement",
			"Englebert" => "Englebert",
			"Enriqueta" => "Enriqueta",
			"Erica One" => "Erica One",
			"Esteban" => "Esteban",
			"Euphoria Script" => "Euphoria Script",
			"Ewert" => "Ewert",
			"Exo" => "Exo",
			"Exo 2" => "Exo 2",
			"Expletus Sans" => "Expletus Sans",
			"Fanwood Text" => "Fanwood Text",
			"Fascinate" => "Fascinate",
			"Fascinate Inline" => "Fascinate Inline",
			"Faster One" => "Faster One",
			"Fasthand" => "Fasthand",
			"Fauna One" => "Fauna One",
			"Federant" => "Federant",
			"Federo" => "Federo",
			"Felipa" => "Felipa",
			"Fenix" => "Fenix",
			"Finger Paint" => "Finger Paint",
			"Fira Mono" => "Fira Mono",
			"Fira Sans" => "Fira Sans",
			"Fjalla One" => "Fjalla One",
			"Fjord One" => "Fjord One",
			"Flamenco" => "Flamenco",
			"Flavors" => "Flavors",
			"Fondamento" => "Fondamento",
			"Fontdiner Swanky" => "Fontdiner Swanky",
			"Forum" => "Forum",
			"Francois One" => "Francois One",
			"Freckle Face" => "Freckle Face",
			"Fredericka the Great" => "Fredericka the Great",
			"Fredoka One" => "Fredoka One",
			"Freehand" => "Freehand",
			"Fresca" => "Fresca",
			"Frijole" => "Frijole",
			"Fruktur" => "Fruktur",
			"Fugaz One" => "Fugaz One",
			"GFS Didot" => "GFS Didot",
			"GFS Neohellenic" => "GFS Neohellenic",
			"Gabriela" => "Gabriela",
			"Gafata" => "Gafata",
			"Galdeano" => "Galdeano",
			"Galindo" => "Galindo",
			"Gentium Basic" => "Gentium Basic",
			"Gentium Book Basic" => "Gentium Book Basic",
			"Geo" => "Geo",
			"Geostar" => "Geostar",
			"Geostar Fill" => "Geostar Fill",
			"Germania One" => "Germania One",
			"Gidugu" => "Gidugu",
			"Gilda Display" => "Gilda Display",
			"Give You Glory" => "Give You Glory",
			"Glass Antiqua" => "Glass Antiqua",
			"Glegoo" => "Glegoo",
			"Gloria Hallelujah" => "Gloria Hallelujah",
			"Goblin One" => "Goblin One",
			"Gochi Hand" => "Gochi Hand",
			"Gorditas" => "Gorditas",
			"Goudy Bookletter 1911" => "Goudy Bookletter 1911",
			"Graduate" => "Graduate",
			"Grand Hotel" => "Grand Hotel",
			"Gravitas One" => "Gravitas One",
			"Great Vibes" => "Great Vibes",
			"Griffy" => "Griffy",
			"Gruppo" => "Gruppo",
			"Gudea" => "Gudea",
			"Gurajada" => "Gurajada",
			"Habibi" => "Habibi",
			"Halant" => "Halant",
			"Hammersmith One" => "Hammersmith One",
			"Hanalei" => "Hanalei",
			"Hanalei Fill" => "Hanalei Fill",
			"Handlee" => "Handlee",
			"Hanuman" => "Hanuman",
			"Happy Monkey" => "Happy Monkey",
			"Headland One" => "Headland One",
			"Henny Penny" => "Henny Penny",
			"Herr Von Muellerhoff" => "Herr Von Muellerhoff",
			"Hind" => "Hind",
			"Holtwood One SC" => "Holtwood One SC",
			"Homemade Apple" => "Homemade Apple",
			"Homenaje" => "Homenaje",
			"IM Fell DW Pica" => "IM Fell DW Pica",
			"IM Fell DW Pica SC" => "IM Fell DW Pica SC",
			"IM Fell Double Pica" => "IM Fell Double Pica",
			"IM Fell Double Pica SC" => "IM Fell Double Pica SC",
			"IM Fell English" => "IM Fell English",
			"IM Fell English SC" => "IM Fell English SC",
			"IM Fell French Canon" => "IM Fell French Canon",
			"IM Fell French Canon SC" => "IM Fell French Canon SC",
			"IM Fell Great Primer" => "IM Fell Great Primer",
			"IM Fell Great Primer SC" => "IM Fell Great Primer SC",
			"Iceberg" => "Iceberg",
			"Iceland" => "Iceland",
			"Imprima" => "Imprima",
			"Inconsolata" => "Inconsolata",
			"Inder" => "Inder",
			"Indie Flower" => "Indie Flower",
			"Inika" => "Inika",
			"Inknut Antiqua" => "Inknut Antiqua",
			"Irish Grover" => "Irish Grover",
			"Istok Web" => "Istok Web",
			"Italiana" => "Italiana",
			"Italianno" => "Italianno",
			"Jacques Francois" => "Jacques Francois",
			"Jacques Francois Shadow" => "Jacques Francois Shadow",
			"Jaldi" => "Jaldi",
			"Jim Nightshade" => "Jim Nightshade",
			"Jockey One" => "Jockey One",
			"Jolly Lodger" => "Jolly Lodger",
			"Josefin Sans" => "Josefin Sans",
			"Josefin Slab" => "Josefin Slab",
			"Joti One" => "Joti One",
			"Judson" => "Judson",
			"Julee" => "Julee",
			"Julius Sans One" => "Julius Sans One",
			"Junge" => "Junge",
			"Jura" => "Jura",
			"Just Another Hand" => "Just Another Hand",
			"Just Me Again Down Here" => "Just Me Again Down Here",
			"Kadwa" => "Kadwa",
			"Kalam" => "Kalam",
			"Kameron" => "Kameron",
			"Kantumruy" => "Kantumruy",
			"Karla" => "Karla",
			"Karma" => "Karma",
			"Kaushan Script" => "Kaushan Script",
			"Kavoon" => "Kavoon",
			"Kdam Thmor" => "Kdam Thmor",
			"Keania One" => "Keania One",
			"Kelly Slab" => "Kelly Slab",
			"Kenia" => "Kenia",
			"Khand" => "Khand",
			"Khmer" => "Khmer",
			"Khula" => "Khula",
			"Kite One" => "Kite One",
			"Knewave" => "Knewave",
			"Kotta One" => "Kotta One",
			"Koulen" => "Koulen",
			"Kranky" => "Kranky",
			"Kreon" => "Kreon",
			"Kristi" => "Kristi",
			"Krona One" => "Krona One",
			"Kurale" => "Kurale",
			"La Belle Aurore" => "La Belle Aurore",
			"Laila" => "Laila",
			"Lakki Reddy" => "Lakki Reddy",
			"Lancelot" => "Lancelot",
			"Lateef" => "Lateef",
			"Lato" => "Lato",
			"League Script" => "League Script",
			"Leckerli One" => "Leckerli One",
			"Ledger" => "Ledger",
			"Lekton" => "Lekton",
			"Lemon" => "Lemon",
			"Libre Baskerville" => "Libre Baskerville",
			"Life Savers" => "Life Savers",
			"Lilita One" => "Lilita One",
			"Lily Script One" => "Lily Script One",
			"Limelight" => "Limelight",
			"Linden Hill" => "Linden Hill",
			"Lobster" => "Lobster",
			"Lobster Two" => "Lobster Two",
			"Londrina Outline" => "Londrina Outline",
			"Londrina Shadow" => "Londrina Shadow",
			"Londrina Sketch" => "Londrina Sketch",
			"Londrina Solid" => "Londrina Solid",
			"Lora" => "Lora",
			"Love Ya Like A Sister" => "Love Ya Like A Sister",
			"Loved by the King" => "Loved by the King",
			"Lovers Quarrel" => "Lovers Quarrel",
			"Luckiest Guy" => "Luckiest Guy",
			"Lusitana" => "Lusitana",
			"Lustria" => "Lustria",
			"Macondo" => "Macondo",
			"Macondo Swash Caps" => "Macondo Swash Caps",
			"Magra" => "Magra",
			"Maiden Orange" => "Maiden Orange",
			"Mako" => "Mako",
			"Mallanna" => "Mallanna",
			"Mandali" => "Mandali",
			"Marcellus" => "Marcellus",
			"Marcellus SC" => "Marcellus SC",
			"Marck Script" => "Marck Script",
			"Margarine" => "Margarine",
			"Marko One" => "Marko One",
			"Marmelad" => "Marmelad",
			"Martel" => "Martel",
			"Martel Sans" => "Martel Sans",
			"Marvel" => "Marvel",
			"Mate" => "Mate",
			"Mate SC" => "Mate SC",
			"Maven Pro" => "Maven Pro",
			"McLaren" => "McLaren",
			"Meddon" => "Meddon",
			"MedievalSharp" => "MedievalSharp",
			"Medula One" => "Medula One",
			"Megrim" => "Megrim",
			"Meie Script" => "Meie Script",
			"Merienda" => "Merienda",
			"Merienda One" => "Merienda One",
			"Merriweather" => "Merriweather",
			"Merriweather Sans" => "Merriweather Sans",
			"Metal" => "Metal",
			"Metal Mania" => "Metal Mania",
			"Metamorphous" => "Metamorphous",
			"Metrophobic" => "Metrophobic",
			"Michroma" => "Michroma",
			"Milonga" => "Milonga",
			"Miltonian" => "Miltonian",
			"Miltonian Tattoo" => "Miltonian Tattoo",
			"Miniver" => "Miniver",
			"Miss Fajardose" => "Miss Fajardose",
			"Modak" => "Modak",
			"Modern Antiqua" => "Modern Antiqua",
			"Molengo" => "Molengo",
			"Molle" => "Molle",
			"Monda" => "Monda",
			"Monofett" => "Monofett",
			"Monoton" => "Monoton",
			"Monsieur La Doulaise" => "Monsieur La Doulaise",
			"Montaga" => "Montaga",
			"Montez" => "Montez",
			"Montserrat" => "Montserrat",
			"Montserrat Alternates" => "Montserrat Alternates",
			"Montserrat Subrayada" => "Montserrat Subrayada",
			"Moul" => "Moul",
			"Moulpali" => "Moulpali",
			"Mountains of Christmas" => "Mountains of Christmas",
			"Mouse Memoirs" => "Mouse Memoirs",
			"Mr Bedfort" => "Mr Bedfort",
			"Mr Dafoe" => "Mr Dafoe",
			"Mr De Haviland" => "Mr De Haviland",
			"Mrs Saint Delafield" => "Mrs Saint Delafield",
			"Mrs Sheppards" => "Mrs Sheppards",
			"Muli" => "Muli",
			"Mystery Quest" => "Mystery Quest",
			"NTR" => "NTR",
			"Neucha" => "Neucha",
			"Neuton" => "Neuton",
			"New Rocker" => "New Rocker",
			"News Cycle" => "News Cycle",
			"Niconne" => "Niconne",
			"Nixie One" => "Nixie One",
			"Nobile" => "Nobile",
			"Nokora" => "Nokora",
			"Norican" => "Norican",
			"Nosifer" => "Nosifer",
			"Nothing You Could Do" => "Nothing You Could Do",
			"Noticia Text" => "Noticia Text",
			"Noto Sans" => "Noto Sans",
			"Noto Serif" => "Noto Serif",
			"Nova Cut" => "Nova Cut",
			"Nova Flat" => "Nova Flat",
			"Nova Mono" => "Nova Mono",
			"Nova Oval" => "Nova Oval",
			"Nova Round" => "Nova Round",
			"Nova Script" => "Nova Script",
			"Nova Slim" => "Nova Slim",
			"Nova Square" => "Nova Square",
			"Numans" => "Numans",
			"Nunito" => "Nunito",
			"Odor Mean Chey" => "Odor Mean Chey",
			"Offside" => "Offside",
			"Old Standard TT" => "Old Standard TT",
			"Oldenburg" => "Oldenburg",
			"Oleo Script" => "Oleo Script",
			"Oleo Script Swash Caps" => "Oleo Script Swash Caps",
			"Open Sans" => "Open Sans",
			"Open Sans Condensed" => "Open Sans Condensed",
			"Oranienbaum" => "Oranienbaum",
			"Orbitron" => "Orbitron",
			"Oregano" => "Oregano",
			"Orienta" => "Orienta",
			"Original Surfer" => "Original Surfer",
			"Oswald" => "Oswald",
			"Over the Rainbow" => "Over the Rainbow",
			"Overlock" => "Overlock",
			"Overlock SC" => "Overlock SC",
			"Ovo" => "Ovo",
			"Oxygen" => "Oxygen",
			"Oxygen Mono" => "Oxygen Mono",
			"PT Mono" => "PT Mono",
			"PT Sans" => "PT Sans",
			"PT Sans Caption" => "PT Sans Caption",
			"PT Sans Narrow" => "PT Sans Narrow",
			"PT Serif" => "PT Serif",
			"PT Serif Caption" => "PT Serif Caption",
			"Pacifico" => "Pacifico",
			"Palanquin" => "Palanquin",
			"Palanquin Dark" => "Palanquin Dark",
			"Paprika" => "Paprika",
			"Parisienne" => "Parisienne",
			"Passero One" => "Passero One",
			"Passion One" => "Passion One",
			"Pathway Gothic One" => "Pathway Gothic One",
			"Patrick Hand" => "Patrick Hand",
			"Patrick Hand SC" => "Patrick Hand SC",
			"Patua One" => "Patua One",
			"Paytone One" => "Paytone One",
			"Peddana" => "Peddana",
			"Peralta" => "Peralta",
			"Permanent Marker" => "Permanent Marker",
			"Petit Formal Script" => "Petit Formal Script",
			"Petrona" => "Petrona",
			"Philosopher" => "Philosopher",
			"Piedra" => "Piedra",
			"Pinyon Script" => "Pinyon Script",
			"Pirata One" => "Pirata One",
			"Plaster" => "Plaster",
			"Play" => "Play",
			"Playball" => "Playball",
			"Playfair Display" => "Playfair Display",
			"Playfair Display SC" => "Playfair Display SC",
			"Podkova" => "Podkova",
			"Poiret One" => "Poiret One",
			"Poller One" => "Poller One",
			"Poly" => "Poly",
			"Pompiere" => "Pompiere",
			"Pontano Sans" => "Pontano Sans",
			"Poppins" => "Poppins",
			"Port Lligat Sans" => "Port Lligat Sans",
			"Port Lligat Slab" => "Port Lligat Slab",
			"Pragati Narrow" => "Pragati Narrow",
			"Prata" => "Prata",
			"Preahvihear" => "Preahvihear",
			"Press Start 2P" => "Press Start 2P",
			"Princess Sofia" => "Princess Sofia",
			"Prociono" => "Prociono",
			"Prosto One" => "Prosto One",
			"Puritan" => "Puritan",
			"Purple Purse" => "Purple Purse",
			"Quando" => "Quando",
			"Quantico" => "Quantico",
			"Quattrocento" => "Quattrocento",
			"Quattrocento Sans" => "Quattrocento Sans",
			"Questrial" => "Questrial",
			"Quicksand" => "Quicksand",
			"Quintessential" => "Quintessential",
			"Qwigley" => "Qwigley",
			"Racing Sans One" => "Racing Sans One",
			"Radley" => "Radley",
			"Rajdhani" => "Rajdhani",
			"Raleway" => "Raleway",
			"Raleway Dots" => "Raleway Dots",
			"Ramabhadra" => "Ramabhadra",
			"Ramaraja" => "Ramaraja",
			"Rambla" => "Rambla",
			"Rammetto One" => "Rammetto One",
			"Ranchers" => "Ranchers",
			"Rancho" => "Rancho",
			"Ranga" => "Ranga",
			"Rationale" => "Rationale",
			"Ravi Prakash" => "Ravi Prakash",
			"Redressed" => "Redressed",
			"Reenie Beanie" => "Reenie Beanie",
			"Revalia" => "Revalia",
			"Rhodium Libre" => "Rhodium Libre",
			"Ribeye" => "Ribeye",
			"Ribeye Marrow" => "Ribeye Marrow",
			"Righteous" => "Righteous",
			"Risque" => "Risque",
			"Roboto" => "Roboto",
			"Roboto Condensed" => "Roboto Condensed",
			"Roboto Mono" => "Roboto Mono",
			"Roboto Slab" => "Roboto Slab",
			"Rochester" => "Rochester",
			"Rock Salt" => "Rock Salt",
			"Rokkitt" => "Rokkitt",
			"Romanesco" => "Romanesco",
			"Ropa Sans" => "Ropa Sans",
			"Rosario" => "Rosario",
			"Rosarivo" => "Rosarivo",
			"Rouge Script" => "Rouge Script",
			"Rozha One" => "Rozha One",
			"Rubik Mono One" => "Rubik Mono One",
			"Rubik One" => "Rubik One",
			"Ruda" => "Ruda",
			"Rufina" => "Rufina",
			"Ruge Boogie" => "Ruge Boogie",
			"Ruluko" => "Ruluko",
			"Rum Raisin" => "Rum Raisin",
			"Ruslan Display" => "Ruslan Display",
			"Russo One" => "Russo One",
			"Ruthie" => "Ruthie",
			"Rye" => "Rye",
			"Sacramento" => "Sacramento",
			"Sahitya" => "Sahitya",
			"Sail" => "Sail",
			"Salsa" => "Salsa",
			"Sanchez" => "Sanchez",
			"Sancreek" => "Sancreek",
			"Sansita One" => "Sansita One",
			"Sarala" => "Sarala",
			"Sarina" => "Sarina",
			"Sarpanch" => "Sarpanch",
			"Satisfy" => "Satisfy",
			"Scada" => "Scada",
			"Scheherazade" => "Scheherazade",
			"Schoolbell" => "Schoolbell",
			"Seaweed Script" => "Seaweed Script",
			"Sevillana" => "Sevillana",
			"Seymour One" => "Seymour One",
			"Shadows Into Light" => "Shadows Into Light",
			"Shadows Into Light Two" => "Shadows Into Light Two",
			"Shanti" => "Shanti",
			"Share" => "Share",
			"Share Tech" => "Share Tech",
			"Share Tech Mono" => "Share Tech Mono",
			"Shojumaru" => "Shojumaru",
			"Short Stack" => "Short Stack",
			"Siemreap" => "Siemreap",
			"Sigmar One" => "Sigmar One",
			"Signika" => "Signika",
			"Signika Negative" => "Signika Negative",
			"Simonetta" => "Simonetta",
			"Sintony" => "Sintony",
			"Sirin Stencil" => "Sirin Stencil",
			"Six Caps" => "Six Caps",
			"Skranji" => "Skranji",
			"Slabo 13px" => "Slabo 13px",
			"Slabo 27px" => "Slabo 27px",
			"Slackey" => "Slackey",
			"Smokum" => "Smokum",
			"Smythe" => "Smythe",
			"Sniglet" => "Sniglet",
			"Snippet" => "Snippet",
			"Snowburst One" => "Snowburst One",
			"Sofadi One" => "Sofadi One",
			"Sofia" => "Sofia",
			"Sonsie One" => "Sonsie One",
			"Sorts Mill Goudy" => "Sorts Mill Goudy",
			"Source Code Pro" => "Source Code Pro",
			"Source Sans Pro" => "Source Sans Pro",
			"Source Serif Pro" => "Source Serif Pro",
			"Special Elite" => "Special Elite",
			"Spicy Rice" => "Spicy Rice",
			"Spinnaker" => "Spinnaker",
			"Spirax" => "Spirax",
			"Squada One" => "Squada One",
			"Sree Krushnadevaraya" => "Sree Krushnadevaraya",
			"Stalemate" => "Stalemate",
			"Stalinist One" => "Stalinist One",
			"Stardos Stencil" => "Stardos Stencil",
			"Stint Ultra Condensed" => "Stint Ultra Condensed",
			"Stint Ultra Expanded" => "Stint Ultra Expanded",
			"Stoke" => "Stoke",
			"Strait" => "Strait",
			"Sue Ellen Francisco" => "Sue Ellen Francisco",
			"Sumana" => "Sumana",
			"Sunshiney" => "Sunshiney",
			"Supermercado One" => "Supermercado One",
			"Sura" => "Sura",
			"Suranna" => "Suranna",
			"Suravaram" => "Suravaram",
			"Suwannaphum" => "Suwannaphum",
			"Swanky and Moo Moo" => "Swanky and Moo Moo",
			"Syncopate" => "Syncopate",
			"Tangerine" => "Tangerine",
			"Taprom" => "Taprom",
			"Tauri" => "Tauri",
			"Teko" => "Teko",
			"Telex" => "Telex",
			"Tenali Ramakrishna" => "Tenali Ramakrishna",
			"Tenor Sans" => "Tenor Sans",
			"Text Me One" => "Text Me One",
			"The Girl Next Door" => "The Girl Next Door",
			"Tienne" => "Tienne",
			"Tillana" => "Tillana",
			"Timmana" => "Timmana",
			"Tinos" => "Tinos",
			"Titan One" => "Titan One",
			"Titillium Web" => "Titillium Web",
			"Trade Winds" => "Trade Winds",
			"Trocchi" => "Trocchi",
			"Trochut" => "Trochut",
			"Trykker" => "Trykker",
			"Tulpen One" => "Tulpen One",
			"Ubuntu" => "Ubuntu",
			"Ubuntu Condensed" => "Ubuntu Condensed",
			"Ubuntu Mono" => "Ubuntu Mono",
			"Ultra" => "Ultra",
			"Uncial Antiqua" => "Uncial Antiqua",
			"Underdog" => "Underdog",
			"Unica One" => "Unica One",
			"UnifrakturCook" => "UnifrakturCook",
			"UnifrakturMaguntia" => "UnifrakturMaguntia",
			"Unkempt" => "Unkempt",
			"Unlock" => "Unlock",
			"Unna" => "Unna",
			"VT323" => "VT323",
			"Vampiro One" => "Vampiro One",
			"Varela" => "Varela",
			"Varela Round" => "Varela Round",
			"Vast Shadow" => "Vast Shadow",
			"Vesper Libre" => "Vesper Libre",
			"Vibur" => "Vibur",
			"Vidaloka" => "Vidaloka",
			"Viga" => "Viga",
			"Voces" => "Voces",
			"Volkhov" => "Volkhov",
			"Vollkorn" => "Vollkorn",
			"Voltaire" => "Voltaire",
			"Waiting for the Sunrise" => "Waiting for the Sunrise",
			"Wallpoet" => "Wallpoet",
			"Walter Turncoat" => "Walter Turncoat",
			"Warnes" => "Warnes",
			"Wellfleet" => "Wellfleet",
			"Wendy One" => "Wendy One",
			"Wire One" => "Wire One",
			"Yanone Kaffeesatz" => "Yanone Kaffeesatz",
			"Yantramanav" => "Yantramanav",
			"Yellowtail" => "Yellowtail",
			"Yeseva One" => "Yeseva One",
			"Yesteryear" => "Yesteryear",
			"Zeyada" => "Zeyada"
		  );

		$standard_fonts = array(
			'0' => 'Select Font',
			'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
			"'Arial Black', Gadget, sans-serif" => "'Arial Black', Gadget, sans-serif",
			"'Bookman Old Style', serif" => "'Bookman Old Style', serif",
			"'Comic Sans MS', cursive" => "'Comic Sans MS', cursive",
			"Courier, monospace" => "Courier, monospace",
			"Garamond, serif" => "Garamond, serif",
			"Georgia, serif" => "Georgia, serif",
			"Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace" => "'Lucida Console', Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif" => "'MS Sans Serif', Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif" => "'MS Serif', 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
			"Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
			"'Times New Roman', Times, serif" => "'Times New Roman', Times, serif",
			"'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif"
		);

		$font_weights = array(
			"100"	=> "Thin (100)",
			"200"	=> "Extra Light (200)",
			"300"	=> "Light (300)",
			"400"	=> "Normal (400)",
			"500"	=> "Medium (500)",
			"600"	=> "Semi Bold (600)",
			"700"	=> "Bold (700)",
			"800"	=> "Bolder (800)",
			"900"	=> "Extra Bold (900)",
		);

		/*-----------------------------------------------------------------------------------*/
		/* The Options Array */
		/*-----------------------------------------------------------------------------------*/

		// Set the Options Array
		$of_options = array();

		$of_options[] = array( "name" => __("General", "Avada"),
			"id" => "heading_general",
			"type" => "heading");

		$of_options[] = array( "name" => __("Code", "Avada"),
			"desc" => "",
			"id" => "code",
			"std" => "<h3 style='margin: 0;'>" . __("Tracking / Space Before Head / Space Before Body Code", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Tracking Code", "Avada"),
			"desc" => __("Paste your Google Analytics (or other) tracking code here. This will be added into the header template of your theme. Please place code inside &lt;script&gt; tags.", "Avada"),
			"id" => "google_analytics",
			"std" => "",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Space before &lt;/head&gt;", "Avada"),
			"desc" => __("Add code before the &lt;/head&gt; tag. Only accepts javascript code wrapped with &lt;script&gt; tags and HTML markup that is valid inside the &lt;head&gt; tag. ", "Avada"),
			"id" => "space_head",
			"std" => "",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Space before &lt;/body&gt;", "Avada"),
			"desc" => __("Add code before the &lt;/body&gt; tag. Only accepts javascript code, wrapped with &lt;script&gt; tags and valid HTML markup.", "Avada"),
			"id" => "space_body",
			"std" => "",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Responsive", "Avada"),
			"id" => "heading_responsive",
			"type" => "heading");

		$of_options[] = array( "name" => __("Responsive Design", "Avada"),
			"desc" => __("Enable to use the responsive design features. If disabled then the fixed layout is used.", "Avada"),
			"id" => "responsive",
			"std" => 1,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Header Responsive Breakpoint", "Avada"),
			"desc" => __("Controls when the desktop header changes to the mobile header. In pixels, ex: 800px.", "Avada"),
			"id" => "side_header_break_point",
			"std" => "800px",
			"type" => "text");

		$of_options[] = array( "name" => __("Site Content Responsive Breakpoint", "Avada"),
			"desc" => __("Controls when the site content area changes to the mobile layout. This includes all content on the page except for the header area and blog/portfolio grid sections. If you are using a side header, the breakpoint value you enter will automatically include the side header width.  In pixels, ex: 800px.", "Avada"),
			"id" => "content_break_point",
			"std" => "800px",
			"type" => "text");


		$of_options[] = array( "name" => __("Grid Responsive Breakpoint", "Avada"),
			"desc" => __("Controls when blog/portfolio grid layouts start to break into smaller amounts of columns. Further breakpoints are auto calculated. In pixels, ex: 1000px.", "Avada"),
			"id" => "grid_main_break_point",
			"std" => "1099px",
			"type" => "text");

		$of_options[] = array( 	"name" 		=> __("Responsive Heading Typography", "Avada"),
			"desc" 		=> __("Check this box if you want site headings to change font size responsively.", "Avada"),
			"id" 		=> "typography_responsive",
			"std" 		=> 0,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Responsive Typography Sensitivity", "Avada"),
			"desc" => __("Values below 1 decrease resizing, values above 1 increase sizing. ex: .6", "Avada"),
			"id" => "typography_sensitivity",
			"std" => "0.6",
			"type" => "text");

		$of_options[] = array( "name" => __("Mininum Font Size Factor", "Avada"),
			"desc" => __("Minimum font factor is used to determine minimum distance between headings and body type by a multiplying value. ex: 1.5", "Avada"),
			"id" => "typography_factor",
			"std" => "1.5",
			"type" => "text");

		$of_options[] = array( "name" => __("Enable Zoom on mobile devices", "Avada"),
			"desc" => __("Enable to allow pinch to zoom on mobile devices.", "Avada"),
			"id" => "mobile_zoom",
			"std" => 1,
			"on" 		=> "Enable",
			"off" 		=> "Disable",
			"type" 		=> "switch"
		);

		$of_options[] = array( "name" => __("Site Width", "Avada"),
			"id" => "heading_site_width",
			"type" => "heading");

		$of_options[] = array( "name" => __("Layout", "Avada"),
			"desc" => __("Select boxed or wide layout.", "Avada"),
			"id" => "layout",
			"std" => "Wide",
			"type" => "select",
			"options" => array(
				'Boxed' => __('Boxed', 'Avada'),
				'Wide' => __('Wide', 'Avada'),
			));

		$of_options[] = array( "name" => __("Site Width", "Avada"),
			"desc" => __("Controls the overall site width. In px or %, ex: 100% or 1170px.", "Avada"),
			"id" => "site_width",
			"std" => "1100px",
			"type" => "text");

	   $of_options[] = array( "name" => __("Sidebar Width", "Avada"),
			"desc" => "",
			"id" => "content_sidebar_width",
			"std" => "<h3 style='margin: 0;'>" . __("Sidebar Width", "Avada") . "</h3><p>" . __("These settings are used on pages with 1 sidebar.", "Avada") . "</p>",
			"type" => "info");

		$of_options[] = array( "name" => __("Sidebar Width", "Avada"),
			"desc" => __("Controls the width of the sidebar. In px or %, ex: 100% or 1170px.", "Avada"),
			"id" => "sidebar_width",
			"std" => "23%",
			"type" => "text");

	   $of_options[] = array( "name" => __("Sidebar + Sidebar Width", "Avada"),
			"desc" => "",
			"id" => "content_sidebar_sidebar_width",
			"std" => "<h3 style='margin: 0;'>" . __("Sidebar + Sidebar Width", "Avada") . "</h3><p>" . __("These settings are used on pages with 2 sidebars.", "Avada") . "</p>",
			"type" => "info");

		$of_options[] = array( "name" => __("Sidebar 1 Width", "Avada"),
			"desc" => __("Controls the width of the sidebar 1. In px or %, ex: 100% or 1170px.", "Avada"),
			"id" => "sidebar_2_1_width",
			"std" => "21%",
			"type" => "text");

		$of_options[] = array( "name" => __("Sidebar 2 Width", "Avada"),
			"desc" => __("Controls the width of the sidebar 2. In px or %, ex: 100% or 1170px.", "Avada"),
			"id" => "sidebar_2_2_width",
			"std" => "21%",
			"type" => "text");

		$of_options[] = array( "name" => __("Header", "Avada"),
			"id" => "heading_header",
			"type" => "heading");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info_1",
			"std" => "<h3 style='margin: 0;'>" . __("Header Content Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Header Position", "Avada"),
			"desc" => __("Select the position of header. Left/Right position will not display the header content options 1-3 on mobile devices, only on desktop.", "Avada"),
			"id" => "header_position",
			"std" => "Top",
			"type" => "select",
			"options" => array('Top' => __('Top', 'Avada'), 'Left' => __('Left', 'Avada'), 'Right' => __('Right', 'Avada')));

		$of_options[] = array( "name" => __("Select a Header Layout", "Avada"),
			"desc" => "",
			"id" => "header_layout",
			"std" => "v1",
			"type" => "images",
			"options" => array(
				"v1" => get_template_directory_uri()."/assets/images/patterns/header1.jpg",
				"v2" => get_template_directory_uri()."/assets/images/patterns/header2.jpg",
				"v3" => get_template_directory_uri()."/assets/images/patterns/header3.jpg",
				"v4" => get_template_directory_uri()."/assets/images/patterns/header4.jpg",
				"v5" => get_template_directory_uri()."/assets/images/patterns/header5.jpg"
			));

		$of_options[] = array( "name" => __("Header Width For Left/Right Position", "Avada"),
			"desc" => __("Controls width of the left or right side header. In pixels, ex: 170px.", "Avada"),
			"id" => "side_header_width",
			"std" => "280px",
			"type" => "text");

		$of_options[] = array( "name" => __("Header Shadow", "Avada"),
			"desc" => __("Check this box to show a header drop shadow. This option is incompatible with Internet Explorer versions older than IE11.", "Avada"),
			"id" => "header_shadow",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("100% Header Width", "Avada"),
			"desc" => __("Check this box to set the header to 100% of the browser width. Uncheck to follow site width. Only works with wide layout mode.", "Avada"),
			"id" => "header_100_width",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Slider Position", "Avada"),
			"desc" => __("Select if the slider shows below or above the header.", "Avada"),
			"id" => "slider_position",
			"std" => "Below",
			"type" => "select",
			"options" => array('Below' => 'Below', 'Above' => 'Above'));

		$of_options[] = array( "name" => __("Header Content 1", "Avada"),
			"desc" => __("Select which content displays in the first content area.", "Avada"),
			"id" => "header_left_content",
			"std" => "Contact Info",
			"type" => "select",
			"options" => array('Contact Info' => 'Contact Info', 'Social Links' => 'Social Links', 'Navigation' => 'Navigation', 'Leave Empty' => 'Leave Empty'));

		$of_options[] = array( "name" => __("Header Content 2", "Avada"),
			"desc" => __("Select which content displays in the second content area.", "Avada"),
			"id" => "header_right_content",
			"std" => "Navigation",
			"type" => "select",
			 "options" => array('Contact Info' => 'Contact Info', 'Social Links' => 'Social Links', 'Navigation' => 'Navigation', 'Leave Empty' => 'Leave Empty'));

		$of_options[] = array( "name" => __("Header Content 3", "Avada"),
			"desc" => __("Select which content displays in the third content area.", "Avada"),
			"id" => "header_v4_content",
			"std" => "Tagline And Search",
			"type" => "select",
			"options" => array('Tagline' => 'Tagline', 'Search' => 'Search', 'Tagline And Search' => 'Tagline And Search', 'Banner' => 'Banner', 'None' => 'Leave Empty'));

		$of_options[] = array( "name" => __("Phone Number For Contact Info", "Avada"),
			"desc" => __("Phone number will display in the Contact Info section of your top header.", "Avada"),
			"id" => "header_number",
			"std" => "Call Us Today! 1.555.555.555",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Email Address For Contact Info", "Avada"),
			"desc" => __("Email address will display in the Contact Info section of your top header.", "Avada"),
			"id" => "header_email",
			"std" => "info@yourdomain.com",
			"type" => "text");

		$of_options[] = array( "name" => __("Banner Code For Content 3", "Avada"),
			"desc" => __("Add HTML banner code for Header Content 3. Simple shortcodes, like buttons, can be used here too. The contents or image will display as long as you have Banner selected for the Header Content 3 option above.", "Avada"),
			"id" => "header_banner_code",
			"std" => '',
			"type" => "textarea");

		$of_options[] = array( "name" => __("Tagline For Content 3", "Avada"),
			"desc" => __("Tagline will display as long as you have Tagline selected for the Header Content 3 option above.", "Avada"),
			"id" => "header_tagline",
			"std" => "Insert Tagline Here",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info_1",
			"std" => "<h3 style='margin: 0;'>" . __("Header Content Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info_2",
			"std" => "<h3 style='margin: 0;'>" . __("Header Background", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Background Image For Header Area", "Avada"),
			"desc" => __("Select an image or insert an image url to use for the header background.", "Avada"),
			"id" => "header_bg_image",
			"std" => "",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("100% Background Image", "Avada"),
			"desc" => __("Check this box to have the header background image display at 100% in width and height and scale according to the browser size.", "Avada"),
			"id" => "header_bg_full",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Parallax Background Image", "Avada"),
			"desc" => __("Check this box to enable parallax scrolling on the background image for header top positions.", "Avada"),
			"id" => "header_bg_parallax",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Background Repeat", "Avada"),
			"desc" => __("Select how the background image repeats.", "Avada"),
			"id" => "header_bg_repeat",
			"std" => "",
			"type" => "select",
			"options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

		// this is for padding, the id is wrong but there for legacy users
		$of_options[] = array( "name" => __("Header Top Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "margin_header_top",
			"std" => "0px",
			"type" => "text");

		// this is for padding, the id is wrong but there for legacy users
		$of_options[] = array( "name" => __("Header Bottom Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "margin_header_bottom",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Header Left Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "padding_header_left",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Header Right Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "padding_header_right",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info_2",
			"std" => "<h3 style='margin: 0;'>" . __("Header Background", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info_3",
			"std" => "<h3 style='margin: 0;'>" . __("Header Social Icons", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( 	"name" => __("Header Social Icons Font Size", "Avada"),
						"desc" 		=> __("In pixels, default is 16", "Avada"),
						"id" 		=> "header_social_links_font_size",
						"std" 		=> "16",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Header Social Icons Custom Color", "Avada"),
			"desc" => __("Select a custom social icon color. Use one hex value for all or separate by | symbol for multi-color. ex: #AA0000|#00AA00|#0000AA", "Avada"),
			"id" => "header_social_links_icon_color",
			"std" => "#bebdbd",
			"type" => "color");

		$of_options[] = array( "name" => __("Header Social Icons Boxed", "Avada"),
			"desc" => __("Controls whether each icon is displayed in a small box.", "Avada"),
			"id" => "header_social_links_boxed",
			"std" => "No",
			"type" => "select",
			"options" => array('No' => 'No', 'Yes' => 'Yes'));

		$of_options[] = array( "name" => __("Header Social Icons Custom Box Color", "Avada"),
			"desc" => __("Select a custom social icon box color. Use one hex value for all or separate by | symbol for multi-color. ex: #AA0000|#00AA00|#0000AA", "Avada"),
			"id" => "header_social_links_box_color",
			"std" => "#e8e8e8",
			"type" => "color");

		$of_options[] = array( "name" => __("Header Social Icons Boxed Radius", "Avada"),
			"desc" => __("Box radius for the social icons. In pixels, ex: 4px.", "Avada"),
			"id" => "header_social_links_boxed_radius",
			"std" => "4px",
			"type" => "text");

		$of_options[] = array( 	"name" => __("Header Social Icons Boxed Padding", "Avada"),
						"desc" 		=> __("In pixels, default is 8", "Avada"),
						"id" 		=> "header_social_links_boxed_padding",
						"std" 		=> "8",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Header Social Icons Tooltip Position", "Avada"),
			"desc" => __("Controls the tooltip position of the social icons in the header.", "Avada"),
			"id" => "header_social_links_tooltip_placement",
			"std" => "Bottom",
			"type" => "select",
			"options" => array( 'Top' => 'Top', 'Right' => 'Right', 'Bottom' => 'Bottom', 'Left' => 'Left', 'None' => 'None' ));

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info_3",
			"std" => "<h3 style='margin: 0;'>" . __("Header Social Icons", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Sticky Header", "Avada"),
			"id" => "heading_sticky_header",
			"type" => "heading");

		$of_options[] = array( "name" => __("Sticky Header Info", "Avada"),
			"desc" => "",
			"id" => "sticky_header_info",
			"std" => "<h3 style='margin: 0;'>" . __("Sticky Header Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Enable Sticky Header", "Avada"),
			"desc" => __("Check to enable a fixed header when scrolling, uncheck to disable.", "Avada"),
			"id" => "header_sticky",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Enable Sticky Header on Tablets", "Avada"),
			"desc" => __("Check to enable a fixed header when scrolling on tablets, uncheck to disable.", "Avada"),
			"id" => "header_sticky_tablet",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Enable Sticky Header on Mobiles", "Avada"),
			"desc" => __("Check to enable a fixed header when scrolling on mobiles, uncheck to disable.", "Avada"),
			"id" => "header_sticky_mobile",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Enable Sticky Header Animation", "Avada"),
			"desc" => __("Enable the sticky header to animate to a smaller height. This will shrink the sticky header height, logo and menu. Only applies to header v1 - v3.", "Avada"),
			"id" => "header_sticky_shrinkage",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Headers 4-5 Sticky Header Display", "Avada"),
			"desc" => __("Select if your sticky header shows the menu or menu + logo area.", "Avada"),
			"id" => "header_sticky_type2_layout",
			"std" => "Menu Only",
			"type" => "select",
			"options" => array( 'menu_only' => 'Menu Only', 'menu_and_logo' => 'Menu + Logo Area' ));

		$of_options[] = array( "name" => __("Sticky Header Menu Item Padding", "Avada"),
			"desc" => __("Controls the space between each menu item in the sticky header. Use a number without 'px', default is 35. ex: 35", "Avada"),
			"id" => "header_sticky_nav_padding",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Sticky Header Navigation Font Size", "Avada"),
			"desc" => __("Controls the font size of the menu items in the sticky header. Use a number without 'px', default is 14. ex: 14", "Avada"),
			"id" => "header_sticky_nav_font_size",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Logo", "Avada"),
			"id" => "heading_logo",
			"type" => "heading");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info",
			"std" => "<h3 style='margin: 0;'>" . __("Default Logo", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Default Logo", "Avada"),
			"desc" => __("Select an image file for your logo.", "Avada"),
			"id" => "logo",
			"std" => get_template_directory_uri()."/assets/images/logo.png",
			"mod" => "min",
			"type" => "media");

		$of_options[] = array( "name" => __("Default Logo (Retina Version @2x)", "Avada"),
			"desc" => __("Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.", "Avada"),
			"id" => "logo_retina",
			"std" => "",
			"mod" => "min",
			"type" => "media");

		$of_options[] = array( "name" => __("Default Logo Width", "Avada"),
			"desc" => __("If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width. Use a number without 'px', ex: 40", "Avada"),
			"id" => "retina_logo_width",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Default Logo Height", "Avada"),
			"desc" => __("If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height. Use a number without 'px', ex: 40", "Avada"),
			"id" => "retina_logo_height",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Sticky Header Logo", "Avada"),
			"desc" => "",
			"id" => "sticky_logo_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Sticky Header Logo", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Sticky Header Logo", "Avada"),
			"desc" => __("Select an image file for your sticky header logo.", "Avada"),
			"id" => "sticky_header_logo",
			"std" => "",
			"mod" => "min",
			"type" => "media");

		$of_options[] = array( "name" => __("Sticky Header Logo (Retina Version @2x)", "Avada"),
			"desc" => __("Select an image file for the retina version of the sticky header logo. It should be exactly 2x the size of sticky header main logo.", "Avada"),
			"id" => "sticky_header_logo_retina",
			"std" => "",
			"mod" => "min",
			"type" => "media");

		$of_options[] = array( "name" => __("Sticky Header Logo Width", "Avada"),
			"desc" => __("If retina logo is uploaded, enter the sticky header logo (1x) version width, do not enter the retina logo width. Use a number without 'px', ex: 40", "Avada"),
			"id" => "sticky_retina_logo_width",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Sticky Header Logo Height", "Avada"),
			"desc" => __("If retina logo is uploaded, enter the sticky header logo (1x) version height, do not enter the retina logo height. Use a number without 'px', ex: 40 ", "Avada"),
			"id" => "sticky_retina_logo_height",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Sticky Header Logo", "Avada"),
			"desc" => "",
			"id" => "sticky_logo_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Sticky Header Logo", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");


		$of_options[] = array( "name" => __("Mobile Logo", "Avada"),
			"desc" => "",
			"id" => "mobile_logo_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Mobile Logo", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Mobile Logo", "Avada"),
			"desc" => __("Select an image file for your mobile logo.", "Avada"),
			"id" => "mobile_logo",
			"std" => "",
			"mod" => "min",
			"type" => "media");

		$of_options[] = array( "name" => __("Mobile Logo (Retina Version @2x)", "Avada"),
			"desc" => __("Select an image file for the retina version of the mobile logo. It should be exactly 2x the size of Mobile main logo.", "Avada"),
			"id" => "mobile_logo_retina",
			"std" => "",
			"mod" => "min",
			"type" => "media");

		$of_options[] = array( "name" => __("Mobile Logo Width", "Avada"),
			"desc" => __("If retina logo is uploaded, enter the mobile logo (1x) version width, do not enter the retina logo width. Use a number without 'px', ex: 40", "Avada"),
			"id" => "mobile_retina_logo_width",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Mobile Logo Height", "Avada"),
			"desc" => __("If retina logo is uploaded, enter the mobile logo (1x) version height, do not enter the retina logo height. Use a number without 'px', ex: 40", "Avada"),
			"id" => "mobile_retina_logo_height",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Mobile Logo", "Avada"),
			"desc" => "",
			"id" => "mobile_logo_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Mobile Logo", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Logo Settings", "Avada"),
			"desc" => "",
			"id" => "logo_settings_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Logo Settings", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Logo Alignment", "Avada"),
			"desc" => __("'Center' only works on Top Header 5 and on Side Headers.", "Avada"),
			"id" => "logo_alignment",
			"std" => "Left",
			"type" => "select",
			"options" => array('Left' => 'Left', 'Center' => 'Center', 'Right' => 'Right',));

		$of_options[] = array( "name" => __("Logo Left Margin", "Avada"),
			"desc" => __("In pixels, ex: 10px", "Avada"),
			"id" => "margin_logo_left",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Logo Right Margin", "Avada"),
			"desc" => __("In pixels, ex: 10px", "Avada"),
			"id" => "margin_logo_right",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Logo Top Margin", "Avada"),
			"desc" => __("In pixels, ex: 10px", "Avada"),
			"id" => "margin_logo_top",
			"std" => "31px",
			"type" => "text");

		$of_options[] = array( "name" => __("Logo Bottom Margin", "Avada"),
			"desc" => __("In pixels, ex: 10px", "Avada"),
			"id" => "margin_logo_bottom",
			"std" => "31px",
			"type" => "text");

		$of_options[] = array( "name" => __("Logo Settings", "Avada"),
			"desc" => "",
			"id" => "logo_settings_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Logo Settings", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Favicon Options", "Avada"),
			"desc" => "",
			"id" => "favicons",
			"std" => "<h3 style='margin: 0;'>" . __("Favicon Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Favicon", "Avada"),
			"desc" => __("Favicon for your website (16px x 16px).", "Avada"),
			"id" => "favicon",
			"std" => "",
			"type" => "upload");

		$of_options[] = array( "name" => __("Apple iPhone Icon Upload", "Avada"),
			"desc" => __("Favicon for Apple iPhone (57px x 57px).", "Avada"),
			"id" => "iphone_icon",
			"std" => "",
			"type" => "upload");

		$of_options[] = array( "name" => __("Apple iPhone Retina Icon Upload", "Avada"),
			"desc" => __("Favicon for Apple iPhone Retina Version (114px x 114px).", "Avada"),
			"id" => "iphone_icon_retina",
			"std" => "",
			"type" => "upload");

		$of_options[] = array( "name" => __("Apple iPad Icon Upload", "Avada"),
			"desc" => __("Favicon for Apple iPad (72px x 72px).", "Avada"),
			"id" => "ipad_icon",
			"std" => "",
			"type" => "upload");

		$of_options[] = array( "name" => __("Apple iPad Retina Icon Upload", "Avada"),
			"desc" => __("Favicon for Apple iPad Retina Version (144px x 144px).", "Avada"),
			"id" => "ipad_icon_retina",
			"std" => "",
			"type" => "upload");

		$of_options[] = array( "name" => __("Favicon Options", "Avada"),
			"desc" => "",
			"id" => "favicons",
			"std" => "<h3 style='margin: 0;'>" . __("Favicon Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Menu", "Avada"),
			"id" => "heading_menu",
			"type" => "heading");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info",
			"std" => "<h3 style='margin: 0;'>" . __("Menu Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Menu Text Align", "Avada"),
			"desc" => __("Controls the alignment of the text in the menu for top headers 4-5 and side headers", "Avada"),
			"id" => "menu_text_align",
			"std" => "center",
			"options" => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'),
			"type" => "select");

		$of_options[] = array( "name" => __("Main Nav Height", "Avada"),
			"desc" => __("Controls menu height. Use a number without 'px', default is 83. ex: 83", "Avada"),
			"id" => "nav_height",
			"std" => "83",
			"type" => "text");

		$of_options[] = array( "name" => __("Main Menu Highlight Bar Size", "Avada"),
			"desc" => __("Controls the border size of the menu highlight bar. Use a number without 'px', default is 3, enter 0 to hide it. ex: 3.", "Avada"),
			"id" => "nav_highlight_border",
			"std" => "3",
			"type" => "text");

		$of_options[] = array( "name" => __("Main Menu Item Padding", "Avada"),
			"desc" => __("Controls right (left on RTL) menu padding. Use a number without 'px', default is 45. ex: 45", "Avada"),
			"id" => "nav_padding",
			"std" => "45",
			"type" => "text");

		$of_options[] = array( "name" => __("Main Menu Dropdown Width", "Avada"),
			"desc" => __("In pixels, ex: 170px", "Avada"),
			"id" => "dropdown_menu_width",
			"std" => "180px",
			"type" => "text");

		$of_options[] = array( "name" => __("Main Menu Dropdown Item Top/Bottom Padding", "Avada"),
			"desc" => __("In pixels, ex: 7px", "Avada"),
			"id" => "mainmenu_dropdown_vertical_padding",
			"std" => "7px",
			"type" => "text");

		$of_options[] = array( "name" => __("Main Menu Dropdown Item Divider", "Avada"),
			"desc" => __("Check to display a divider on the menu dropdown items.", "Avada"),
			"id" => "mainmenu_dropdown_display_divider",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Top Menu Dropdown Width", "Avada"),
			"desc" => __("In pixels, ex: 100px", "Avada"),
			"id" => "topmenu_dropwdown_width",
			"std" => "180px",
			"type" => "text");

		$of_options[] = array( "name" => __("Mega Menu Max-Width", "Avada"),
			"desc" => __('Controls the the max width of the mega menu. In pixels, ex: 1100px.', 'Avada'),
			"id" => "megamenu_max_width",
			"std" => "1100px",
			"type" => "text");

		$of_options[] = array( "name" => __("Mega Menu Column Title Size", "Avada"),
			"desc" => __("Set the font size for mega menu column titles (menu 2nd level labels). In pixels, ex: 18px", "Avada"),
			"id" => "megamenu_title_size",
			"std" => "18px",
			"type" => "text");

		$of_options[] = array( "name" => __("Mega Menu Item Top/Bottom Padding", "Avada"),
			"desc" => __("In pixels, ex: 5px", "Avada"),
			"id" => "megamenu_item_vertical_padding",
			"std" => "5px",
			"type" => "text");

		$of_options[] = array( "name" => __("Mega Menu Item Divider", "Avada"),
			"desc" => __("Check to display a divider on the mega menu submenu items.", "Avada"),
			"id" => "megamenu_item_display_divider",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Dropdown Menu Indicator", "Avada"),
			"desc" => __("Check the box to enable arrow indicators next to parent level menu items.", "Avada"),
			"id" => "menu_display_dropdown_indicator",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Menu Drop Shadow", "Avada"),
			"desc" => __("Check to enable the dropshadow for menu dropdowns, uncheck to disable.", "Avada"),
			"id" => "megamenu_shadow",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Display Search Icon in Main Nav", "Avada"),
			"desc" => __("Check to display the search icon in the main menu.", "Avada"),
			"id" => "main_nav_search_icon",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Enable Circle Border On Menu Icons", "Avada"),
			"desc" => __("Check to enable a circle border on the main menu cart and search icons.", "Avada"),
			"id" => "main_nav_icon_circle",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info",
			"std" => "<h3 style='margin: 0;'>" . __("Menu Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "mobile_menu_options",
			"std" => "<h3 style='margin: 0;'>" . __("Mobile Menu Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Mobile Menu Design Style", "Avada"),
			"desc" => __("Select between classic or modern mobile design.", "Avada"),
			"id" => "mobile_menu_design",
			"std" => "modern",
			"options" => array('classic' => 'Classic', 'modern' => 'Modern'),
			"type" => "select");

		$of_options[] = array( "name" => __("Mobile Menu Item Padding", "Avada"),
			"desc" => __("Controls right (left on RTL) menu padding on mobile devices when the normal menu is used. Use a number without 'px', default is 25. ex: 25", "Avada"),
			"id" => "mobile_nav_padding",
			"std" => "25",
			"type" => "text");

		$of_options[] = array( "name" => __("Mobile Menu Text Align", "Avada"),
			"desc" => __("Controls the alignment of menu text on mobile menu.", "Avada"),
			"id" => "mobile_menu_text_align",
			"std" => "left",
			"options" => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'),
			"type" => "select");

		$of_options[] = array( "name" => __("Mobile Menu Icons Top Margin", "Avada"),
			"desc" => __("Controls the top margin for the icons in the modern mobile menu sticky header. In pixels, ex: 100px", "Avada"),
			"id" => "mobile_menu_icons_top_margin",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Mobile Menu Navigation Height", "Avada"),
			"desc" => __("Controls the menu height of each menu item. Use a number without 'px', default is 35.", "Avada"),
			"id" => "mobile_menu_nav_height",
			"std" => "35",
			"type" => "text");

		$of_options[] = array( "name" => __("Mobile Menu Submenu Slide Outs", "Avada"),
			"desc" => __("Check to group submenu to slideout elements on mobile menu.", "Avada"),
			"id" => "mobile_nav_submenu_slideout",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "mobile_menu_options",
			"std" => "<h3 style='margin: 0;'>" . __("Mobile Menu Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Page Title Bar", "Avada"),
			"id" => "heading_page_title_bar",
			"type" => "heading");

			$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info",
			"std" => "<h3 style='margin: 0;'>" . __("Page Title Bar Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Page Title Bar", "Avada"),
			"desc" => __("Check the box to show the page title bar. This is a global option for every page or post, and this can be overridden by individual page/post options.", "Avada"),
			"id" => "page_title_bar",
			"std" => "bar_and_content",
			"options" => array('bar_and_content' => 'Show Bar and Content', 'content_only' => 'Show Content Only', 'hide' => 'Hide'),
			"type" => "select");

		$of_options[] = array( "name" => __("Page Title Bar Text", "Avada"),
			"desc" => __("Choose to show or hide the page title bar text.", "Avada"),
			"id" => "page_title_bar_text",
			"std" => "yes",
			"options" => array('yes' => __('Show', 'Avada'), 'no' => __('Hide', 'Avada')),
			"type" => "select");

		$of_options[] = array( "name" => __("100% Page Title Width", "Avada"),
			"desc" => __("Check this box to set the page title content to 100% of the browser width. Uncheck to follow site width. Only works with wide layout mode.", "Avada"),
			"id" => "page_title_100_width",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Page Title Bar Height", "Avada"),
			"desc" => __("In pixels, ex: 10px", "Avada"),
			"id" => "page_title_height",
			"std" => "87px",
			"type" => "text");

		$of_options[] = array( "name" => __("Page Title Bar Mobile Height", "Avada"),
			"desc" => __("In pixels, ex: 10px", "Avada"),
			"id" => "page_title_mobile_height",
			"std" => "70px",
			"type" => "text");

		$of_options[] = array( "name" => __("Page Title Bar Text Alignment", "Avada"),
			"desc" => __("Choose the title and subhead text alignment", "Avada"),
			"id" => "page_title_alignment",
			"std" => "left",
			"options" => array('left' => 'Left', 'center' => 'Center', 'right' => 'Right'),
			"type" => "select");

		$of_options[] = array( "name" => __("Page Title Bar Background", "Avada"),
			"desc" => __("Select an image or insert an image url to use for the page title bar background.", "Avada"),
			"id" => "page_title_bg",
			"std" => get_template_directory_uri()."/assets/images/page_title_bg.png",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("Page Title Bar Background (Retina Version @2x)", "Avada"),
			"desc" => __("Select an image or insert an image url to use for the retina page title bar background.", "Avada"),
			"id" => "page_title_bg_retina",
			"std" => "",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("100% Background Image", "Avada"),
			"desc" => __("Check this box to have the page title bar background image display at 100% in width and height and scale according to the browser size.", "Avada"),
			"id" => "page_title_bg_full",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Parallax Background Image", "Avada"),
			"desc" => __("Check to enable parallax background image when scrolling.", "Avada"),
			"id" => "page_title_bg_parallax",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Fading Animation", "Avada"),
			"desc" => __("Choose to have the page title text fade on scroll.", "Avada"),
			"id" => "page_title_fading",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Header Info", "Avada"),
			"desc" => "",
			"id" => "header_info",
			"std" => "<h3 style='margin: 0;'>" . __("Breadcrumb Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Breadcrumbs/Search Box", "Avada"),
			"desc" => __("Choose to display breadcrumbs, search box or none in the page title bar.", "Avada"),
			"id" => "page_title_bar_bs",
			"std" => "Breadcrumbs",
			"options" => array('none' => 'None', 'Breadcrumbs' => 'Breadcrumbs', 'Search Box' => 'Search Box'),
			"type" => "select");

		$of_options[] = array( "name" => __("Breadcrumbs on Mobile Devices", "Avada"),
			"desc" => __("Check to display breadcrumbs on mobile devices.", "Avada"),
			"id" => "breadcrumb_mobile",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Breadcrumb Menu Prefix", "Avada"),
			"desc" => __("The text before the breadcrumb menu.", "Avada"),
			"id" => "breacrumb_prefix",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Breadcrumb Menu Separator", "Avada"),
			"desc" => __("Choose a separator between the single breadcrumbs.", "Avada"),
			"id" => "breadcrumb_separator",
			"std" => "/",
			"type" => "text");

		$of_options[] = array( "name" => __("Show Custom Post Type Archives on Breadcrumbs", "Avada"),
			"desc" => __("Check to display custom post type archives in the breadcrumb path.", "Avada"),
			"id" => "breadcrumb_show_post_type_archive",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Post Categories on Breadcrumbs", "Avada"),
			"desc" => __("Check to display the post categories in the breadcrumb path.", "Avada"),
			"id" => "breadcrumb_show_categories",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Sliding Bar", "Avada"),
			"id" => "heading_sliding_bar",
			"type" => "heading");

		$of_options[] = array( "name" => __("Sliding Bar", "Avada"),
			"desc" => "",
			"id" => "sliding_bar",
			"std" => "<h3 style='margin: 0;'>" . __("Sliding Bar Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Enable Sliding Bar", "Avada"),
			"desc" => __("Check to enable the top Sliding Bar.", "Avada"),
			"id" => "slidingbar_widgets",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Sliding Bar On Mobile", "Avada"),
			"desc" => __("Check to disable the top Sliding Bar on mobile devices.", "Avada"),
			"id" => "mobile_slidingbar_widgets",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Enable Top Border on Sliding Bar", "Avada"),
			"desc" => __("Check to enable a top border on the Sliding Bar.", "Avada"),
			"id" => "slidingbar_top_border",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Sliding Bar Open On Page Load", "Avada"),
			"desc" => __("Check the box to have the sliding bar open when the page loads.", "Avada"),
			"id" => "slidingbar_open_on_load",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Number of Sliding Bar Columns", "Avada"),
			"desc" => __("Select the number of columns to display in the Sliding Bar.", "Avada"),
			"id" => "slidingbar_widgets_columns",
			"std" => "2",
			"options" => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
			"type" => "select");

		$of_options[] = array( "name" => __("Footer", "Avada"),
			"id" => "heading_footer",
			"type" => "heading");

		$of_options[] = array( "name" => __("General Footer Options", "Avada"),
			"desc" => "",
			"id" => "footer_widgets_area_title",
			"std" => "<h3 style='margin: 0;'>" . __("General Footer Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("100% Footer Width", "Avada"),
			"desc" => __("Check this box to set footer width to 100% of the browser width. Uncheck to follow site width. Only works with wide layout mode.", "Avada"),
			"id" => "footer_100_width",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => "Footer Special Effects",
			"desc" 		=> "Select your preferred footer special effect.",
			"id" 		=> "footer_special_effects",
			"std" 		=> "none",
			"type" 		=> "radio",
			"options" 	=> array("none" => __( "None", "Avada" ), "footer_parallax_effect" => __( "Footer Parallax Effect", "Avada" ), "footer_area_bg_parallax" => __( "Parallax Background Image", "Avada" ), "footer_sticky" => __("Sticky Footer", "Avada" ), "footer_sticky_with_parallax_bg_image" => __("Sticky Footer and Parallax Background Image", "Avada" ) )
		);

		$of_options[] = array( "name" => __( "Footer Parallax Effect Info", "Avada"),
			"desc" => "",
			"id" => "footer_parallax_effect_info",
			"std" => __("This enables a fixed footer with parallax scrolling effect.", "Avada" ),
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __( "Parallax Background Image Info", "Avada"),
			"desc" => "",
			"id" => "footer_area_bg_parallax_info",
			"std" => __("This enables a parallax effect on the background image selected in 'Background Image For Footer Widget Area' field.", "Avada" ),
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Sticky Footer Info", "Avada"),
			"desc" => "",
			"id" => "footer_sticky_info",
			"std" => __("This enables a sticky footer. The entire footer area will always be 'below the fold'. On very short pages, it makes sure that the footer sticks at the bottom, just above the fold.<br />IMPORTANT: 'Sticky Footer Height' field must be filled in.", "Avada" ),
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Sticky Footer and Parallax Background Image Info", "Avada"),
			"desc" => "",
			"id" => "footer_sticky_with_parallax_bg_image_info",
			"std" => __("This enables a sticky footer together with a parallax effect on the background image. The entire footer area will always be 'below the fold'. IMPORTANT: 'Sticky Footer Height' field must be filled in.", "Avada" ),
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Sticky Footer Height", "Avada"),
			"desc" => __("The entire height of the footer area (widgets + copyright). <a href='https://theme-fusion.com/avada-doc/footer-special-effects/' target='_blank'>View tutorial here</a>. Set a static height in px to enable sticky footer effect. ex: 200px..", "Avada"),
			"id" => "footer_sticky_height",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Footer Widgets Area", "Avada"),
			"desc" => "",
			"id" => "footer_widgets_area_title",
			"std" => "<h3 style='margin: 0;'>" . __("Footer Widgets Area Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Footer Widgets", "Avada"),
			"desc" => __("Check the box to display footer widgets.", "Avada"),
			"id" => "footer_widgets",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Footer Widgets Center Content", "Avada"),
			"desc" => __("Check the box to display the footer widget area contents centered.", "Avada"),
			"id" => "footer_widgets_center_content",
			"std" => 0,
			"type" => "checkbox");


		$of_options[] = array( "name" => __("Number of Footer Columns", "Avada"),
			"desc" => __("Select the number of columns to display in the footer.", "Avada"),
			"id" => "footer_widgets_columns",
			"std" => "4",
			"options" => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
			"type" => "select");

		$of_options[] = array( "name" => __("Background Image For Footer Widget Area", "Avada"),
			"desc" => __("Select an image or insert an image url to use for the footer widget area backgroud.", "Avada"),
			"id" => "footerw_bg_image",
			"std" => "",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("100% Background Image", "Avada"),
			"desc" => __("Check this box to have the footer background image display at 100% in width and height and scale according to the browser size.", "Avada"),
			"id" => "footerw_bg_full",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Background Repeat", "Avada"),
			"desc" => __("Select how the background image repeats.", "Avada"),
			"id" => "footerw_bg_repeat",
			"std" => "",
			"type" => "select",
			"options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

		$of_options[] = array( "name" => __("Background Position", "Avada"),
			"desc" => __("Select the position from where background image starts.", "Avada"),
			"id" => "footerw_bg_pos",
			"std" => "center center",
			"type" => "select",
			"options" => $body_pos);

		$of_options[] = array( "name" => __("Footer Top Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "footer_area_top_padding",
			"std" => "43px",
			"type" => "text");

		$of_options[] = array( "name" => __("Footer Bottom Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "footer_area_bottom_padding",
			"std" => "40px",
			"type" => "text");


		$of_options[] = array( "name" => __("Footer Left Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "footer_area_left_padding",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Footer Right Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "footer_area_right_padding",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Copyright Area / Social Icon Options", "Avada"),
			"desc" => "",
			"id" => "copyright_area_title",
			"std" => "<h3 style='margin: 0;'>". __("Footer Copyright Area Options", "Avada"). "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Copyright Bar", "Avada"),
			"desc" => __("Check the box to display the copyright bar.", "Avada"),
			"id" => "footer_copyright",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Copyright Center Content", "Avada"),
			"desc" => __("Check the box to display the copyright bar contents centered.", "Avada"),
			"id" => "footer_copyright_center_content",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Copyright Text", "Avada"),
			"desc" => __("Enter the text that displays in the copyright bar. HTML markup can be used.", "Avada"),
			"id" => "footer_text",
			"std" => 'Copyright 2012 Avada | All Rights Reserved | Powered by <a href="http://wordpress.org">WordPress</a>  |  <a href="http://theme-fusion.com">Theme Fusion</a>',
			"type" => "textarea");

		$of_options[] = array( "name" => __("Copyright Top Padding", "Avada"),
			"desc" => __("In pixels, ex: 18px", "Avada"),
			"id" => "copyright_top_padding",
			"std" => "18px",
			"type" => "text");

		$of_options[] = array( "name" => __("Copyright Bottom Padding", "Avada"),
			"desc" => __("In pixels, ex: 18px", "Avada"),
			"id" => "copyright_bottom_padding",
			"std" => "16px",
			"type" => "text");

		$of_options[] = array( "name" => __("Social Icon Options", "Avada"),
			"desc" => "",
			"id" => "footer_social_icon_title",
			"std" => "<h3 style='margin: 0;'>" . __("Social Icon Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Display Social Icons on Footer of the Page", "Avada"),
			"desc" => __("Select the checkbox to show social media icons on the footer of the page.", "Avada"),
			"id" => "icons_footer",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( 	"name" => __("Footer Social Icons Font Size", "Avada"),
						"desc" 		=> __("In pixels, default is 16", "Avada"),
						"id" 		=> "footer_social_links_font_size",
						"std" 		=> "16",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Footer Social Icons Custom Color", "Avada"),
			"desc" => __("Select a custom social icon color. Use one hex value for all or separate by | symbol for multi-color. ex: #AA0000|#00AA00|#0000AA", "Avada"),
			"id" => "footer_social_links_icon_color",
			"std" => "#46494a",
			"type" => "color");

		$of_options[] = array( "name" => __("Footer Social Icons Boxed", "Avada"),
			"desc" => __("Controls whether each icon is displayed in a small box.", "Avada"),
			"id" => "footer_social_links_boxed",
			"std" => "No",
			"type" => "select",
			"options" => array('No' => 'No', 'Yes' => 'Yes'));

		$of_options[] = array( "name" => __("Footer Social Icons Custom Box Color", "Avada"),
			"desc" => __("Select a custom social icon box color. Use one hex value for all or separate by | symbol for multi-color. ex: #AA0000|#00AA00|#0000AA", "Avada"),
			"id" => "footer_social_links_box_color",
			"std" => "#222222",
			"type" => "color");

		$of_options[] = array( "name" => __("Footer Social Icons Boxed Radius", "Avada"),
			"desc" => __("Box radius for the social icons. In pixels, ex: 4px.", "Avada"),
			"id" => "footer_social_links_boxed_radius",
			"std" => "4px",
			"type" => "text");


		$of_options[] = array( 	"name" => __("Footer Social Icons Boxed Padding", "Avada"),
						"desc" 		=> __("In pixels, default is 8", "Avada"),
						"id" 		=> "footer_social_links_boxed_padding",
						"std" 		=> "8",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Footer Social Icons Tooltip Position", "Avada"),
			"desc" => __("Controls the tooltip position of the social icons in the footer.", "Avada"),
			"id" => "footer_social_links_tooltip_placement",
			"std" => "Top",
			"type" => "select",
			"options" => array( 'Top' => 'Top', 'Right' => 'Right', 'Bottom' => 'Bottom', 'Left' => 'Left', 'None' => 'None' ));

		$of_options[] = array( "name" => __("Sidebars", "Avada"),
			"id" => "heading_sidebars",
			"type" => "heading");

		$of_options[] = array( "name" => __('Pages', "Avada"),
			"desc" => "",
			"id" => "pages_sidebars",
			"std" => "<h3 style='margin: 0;'>" . __("Pages", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Activate Global Sidebar", "Avada"),
			"desc" => __("Check the box if you want to use a global sidebar on all pages. This option overrides the page options.", "Avada"),
			"id" => "pages_global_sidebar",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Global Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on all pages.", "Avada"),
			"id" => "pages_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on all pages. Sidebar 2 can only be used if sidebar 1 is selected", "Avada"),
			"id" => "pages_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Sidebar Position", "Avada"),
			"desc" => __("Select the sidebar 1 position for pages. If sidebar 2 is selected, it will display on the opposite side.", "Avada"),
			"id" => "default_sidebar_pos",
			"std" => "Right",
			"options" => array('Right' => 'Right', 'Left' => 'Left'),
			"type" => "select");

		$of_options[] = array( "name" => __('Pages', "Avada"),
			"desc" => "",
			"id" => "pages",
			"std" => "<h3 style='margin: 0;'>" . __("Pages", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Portfolio Posts", "Avada"),
			"desc" => "",
			"id" => "portfolio",
			"std" => "<h3 style='margin: 0;'>" . __("Portfolio Posts", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Activate Global Sidebar", "Avada"),
			"desc" => __("Check the box if you want to use a global sidebar on all single portfolio posts. This option overrides the portfolio options.", "Avada"),
			"id" => "portfolio_global_sidebar",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Global Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on all single portfolio posts.", "Avada"),
			"id" => "portfolio_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on all single portfolio posts. Sidebar 2 can only be used if sidebar 1 is selected", "Avada"),
			"id" => "portfolio_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Portfolio Sidebar Position", "Avada"),
			"desc" => __("Select the sidebar 1 position for the portfolio. If sidebar 2 is selected, it will display on the opposite side.", "Avada"),
			"id" => "portfolio_sidebar_position",
			"std" => "Right",
			"type" => "select",
			"options" => array(
				'Right' => 'Right',
				'Left' => 'Left',
			));

		$of_options[] = array( "name" => __("Portfolio Posts", "Avada"),
			"desc" => "",
			"id" => "portfolio_posts",
			"std" => "<h3 style='margin: 0;'>" . __("Portfolio Posts", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Portfolio Archive/Category Pages", "Avada"),
			"desc" => "",
			"id" => "portfolio_archive",
			"std" => "<h3 style='margin: 0;'>" . __("Portfolio Archive/Category Pages", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Portfolio Archive/Category Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on the archive/category pages.", "Avada"),
			"id" => "portfolio_archive_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Portfolio Archive/Category Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on the archive/category pages. Sidebar 2 can only be used if sidebar 1 is selected.", "Avada"),
			"id" => "portfolio_archive_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Portfolio Archive/Category Pages", "Avada"),
			"desc" => "",
			"id" => "portfolio_archive",
			"std" => "<h3 style='margin: 0;'>" . __("Portfolio Archive/Category Pages", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Blog Posts", "Avada"),
			"desc" => "",
			"id" => "blog_posts",
			"std" => "<h3 style='margin: 0;'>" . __("Blog Posts", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Activate Global Sidebar", "Avada"),
			"desc" => __("Check the box if you want to use a global sidebar on all single posts. This option overrides the post options.", "Avada"),
			"id" => "posts_global_sidebar",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Global Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on all single posts.", "Avada"),
			"id" => "posts_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on all single posts.", "Avada"),
			"id" => "posts_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Blog Sidebar Position", "Avada"),
			"desc" => __("Select the sidebar 1 position for the blog pages. If sidebar 2 is selected, it will display on the opposite side.", "Avada"),
			"id" => "blog_sidebar_position",
			"std" => "Right",
			"type" => "select",
			"options" => array(
				'Right' => 'Right',
				'Left' => 'Left',
			));

		$of_options[] = array( "name" => __("Blog Posts", "Avada"),
			"desc" => "",
			"id" => "blog_posts",
			"std" => "<h3 style='margin: 0;'>" . __("Blog Posts", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Blog Archive/Category Pages", "Avada"),
			"desc" => "",
			"id" => "blog_archives",
			"std" => "<h3 style='margin: 0;'>" . __("Blog Archive/Category Pages", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Blog Archive/Category Sidebar 1", "Avada"),
			"desc" => __("Select the sidebar 1 that will display on the blog archive/category pages.", "Avada"),
			"id" => "blog_archive_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Blog Archive/Category Sidebar 2", "Avada"),
			"desc" => __("Select the sidebar 2 that will display on the blog archive/category pages. Sidebar 2 can only be used if sidebar 1 is selected.", "Avada"),
			"id" => "blog_archive_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Blog Archive/Category Pages", "Avada"),
			"desc" => "",
			"id" => "blog_archives",
			"std" => "<h3 style='margin: 0;'>" . __("Blog Archive/Category Pages", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Woocommerce Products", "Avada"),
			"desc" => "",
			"id" => "woo_products",
			"std" => "<h3 style='margin: 0;'>" . __("Woocommerce Products", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Activate Global Sidebar", "Avada"),
			"desc" => __("Check the box if you want to use a global sidebar on the main shop page and all single product pages. This option overrides the woocommerce options.", "Avada"),
			"id" => "woo_global_sidebar",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Global Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on all single product pages.", "Avada"),
			"id" => "woo_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on all single product pages. Sidebar 2 can only be used if sidebar 1 is selected", "Avada"),
			"id" => "woo_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Woocommerce Sidebar Position", "Avada"),
			"desc" => __("Select the sidebar 1 position for woocommerce. If sidebar 2 is selected, it will display on the opposite side.", "Avada"),
			"id" => "woo_sidebar_position",
			"std" => "Right",
			"type" => "select",
			"options" => array(
				'Right' => 'Right',
				'Left' => 'Left',
			));

		$of_options[] = array( "name" => __("Woocommerce Products", "Avada"),
			"desc" => "",
			"id" => "woo_products",
			"std" => "<h3 style='margin: 0;'>" . __("Woocommerce Products", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("WooCommerce Archive/Category Pages", "Avada"),
			"desc" => "",
			"id" => "woo_archives",
			"std" => "<h3 style='margin: 0;'>" . __("WooCommerce Archive/Category Pages", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Woocommerce Archive/Category Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on the archive/category pages.", "Avada"),
			"id" => "woocommerce_archive_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Woocommerce Archive/Category Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on the archive/category pages. Sidebar 2 can only be used if sidebar 1 is selected.", "Avada"),
			"id" => "woocommerce_archive_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("WooCommerce Archive/Category Pages", "Avada"),
			"desc" => "",
			"id" => "woo_archives",
			"std" => "<h3 style='margin: 0;'>" . __("WooCommerce Archive/Category Pages", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Search Page", "Avada"),
			"desc" => "",
			"id" => "search_only",
			"std" => "<h3 style='margin: 0;'>" . __("Search Page", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Search Page Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on the search results page.", "Avada"),
			"id" => "search_sidebar",
			"std" => "Blog Sidebar",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Search Page Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on the search results page. Sidebar 2 can only be used if sidebar 1 is selected.", "Avada"),
			"id" => "search_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Search Sidebar Position", "Avada"),
			"desc" => __("Select the sidebar 1 position for the search pages. If sidebar 2 is selected, it will display on the opposite side.", "Avada"),
			"id" => "search_sidebar_position",
			"std" => "Right",
			"type" => "select",
			"options" => array(
				'Right' => 'Right',
				'Left' => 'Left',
			));

		$of_options[] = array( "name" => __("Search Page", "Avada"),
			"desc" => "",
			"id" => "search_only",
			"std" => "<h3 style='margin: 0;'>" . __("Search Page", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Background", "Avada"),
			"id" => "heading_background",
			"type" => "heading");

		$of_options[] = array( "name" => __("Boxed Mode Only", "Avada"),
			"desc" => "",
			"id" => "boxed_mode_only",
			"std" => "<h3 style='margin: 0;'>" . __("Background options below only work in boxed mode", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Background Image For Outer Areas In Boxed Mode", "Avada"),
			"desc" => __("Select an image or insert an image url to use for the backgroud.", "Avada"),
			"id" => "bg_image",
			"std" => "",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("100% Background Image", "Avada"),
			"desc" => __("Check this box to have the background image display at 100% in width and height and scale according to the browser size.", "Avada"),
			"id" => "bg_full",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Background Repeat", "Avada"),
			"desc" => __("Select how the background image repeats.", "Avada"),
			"id" => "bg_repeat",
			"std" => "",
			"type" => "select",
			"options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

		$of_options[] = array( "name" => __("Background Color For Outer Areas In Boxed Mode", "Avada"),
			"desc" => __("Select a background color.", "Avada"),
			"id" => "bg_color",
			"std" => "#d7d6d6",
			"type" => "color");

		$of_options[] = array( "name" => __("Background Pattern", "Avada"),
			"desc" => __("Check the box to display a pattern in the background. If checked, select the pattern from below.", "Avada"),
			"id" => "bg_pattern_option",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Select a Background Pattern", "Avada"),
			"desc" => "",
			"id" => "bg_pattern",
			"std" => "pattern1",
			"type" => "images",
			"options" => array(
				"pattern1" => get_template_directory_uri()."/assets/images/patterns/pattern1.png",
				"pattern2" => get_template_directory_uri()."/assets/images/patterns/pattern2.png",
				"pattern3" => get_template_directory_uri()."/assets/images/patterns/pattern3.png",
				"pattern4" => get_template_directory_uri()."/assets/images/patterns/pattern4.png",
				"pattern5" => get_template_directory_uri()."/assets/images/patterns/pattern5.png",
				"pattern6" => get_template_directory_uri()."/assets/images/patterns/pattern6.png",
				"pattern7" => get_template_directory_uri()."/assets/images/patterns/pattern7.png",
				"pattern8" => get_template_directory_uri()."/assets/images/patterns/pattern8.png",
				"pattern9" => get_template_directory_uri()."/assets/images/patterns/pattern9.png",
				"pattern10" => get_template_directory_uri()."/assets/images/patterns/pattern10.png",
			));

		$of_options[] = array( "name" => __("Both Modes", "Avada"),
			"desc" => "",
			"id" => "both_modes_only",
			"std" => "<h3 style='margin: 0;'>" . __("Background Options Below Work For Boxed & Wide Mode", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Background Image For Main Content Area", "Avada"),
			"desc" => __("Select an image or insert an image url to use for the main content area backgroud.", "Avada"),
			"id" => "content_bg_image",
			"std" => "",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("100% Background Image", "Avada"),
			"desc" => __("Check this box to have the background image display at 100% in width and height and scale according to the browser size.", "Avada"),
			"id" => "content_bg_full",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Background Repeat", "Avada"),
			"desc" => __("Select how the background image repeats.", "Avada"),
			"id" => "content_bg_repeat",
			"std" => "",
			"type" => "select",
			"options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

		$of_options[] = array( "name" => __("Typography", "Avada"),
			"id" => "heading_typography",
			"type" => "heading");

	   $of_options[] = array( "name" => __("Custom Nav / Headings Font", "Avada"),
			"desc" => "",
			"id" => "custom_heading_font",
			"std" => "<h3 style='margin: 0;'>" . __("Custom Font For Menus And Headings", "Avada") . "</h3><p style='margin-bottom:0;'>" . __("This will override the google / standard font options. All 4 files are required.", "Avada") . "</p>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Custom Font .woff", "Avada"),
			"desc" => __("Upload the .woff font file.", "Avada"),
			"id" => "custom_font_woff",
			"std" => "",
			"type" => "upload");

		$of_options[] = array( "name" => __("Custom Font .ttf", "Avada"),
			"desc" => __("Upload the .ttf font file.", "Avada"),
			"id" => "custom_font_ttf",
			"std" => "",
			"type" => "upload");

		$of_options[] = array( "name" => __("Custom Font .svg", "Avada"),
			"desc" => __("Upload the .svg font file.", "Avada"),
			"id" => "custom_font_svg",
			"std" => "",
			"type" => "upload");

		$of_options[] = array( "name" => __("Custom Font .eot", "Avada"),
			"desc" => __("Upload the .eot font file.", "Avada"),
			"id" => "custom_font_eot",
			"std" => "",
			"type" => "upload");

	   $of_options[] = array( "name" => __("Custom Nav / Headings Font", "Avada"),
			"desc" => "",
			"id" => "custom_heading_font",
			"std" => "<h3 style='margin: 0;'>" . __("Custom Font For Menus And Headings", "Avada") . "</h3><p style='margin-bottom:0;'>" . __("This will override the google / standard font options. All 4 files are required.", "Avada") . "</p>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Google Fonts", "Avada"),
			"desc" => "",
			"id" => "google_fonts_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Google Fonts", "Avada") . "</h3><p style='margin-bottom:0;'>" . __("This will override standard font options.", "Avada" ) . "</p>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Select Body Font Family", "Avada"),
			"desc" => __("Select a font family for body text", "Avada"),
			"id" => "google_body",
			"std" => "PT Sans",
			"type" => "select",
			"options" => $google_fonts);

		$of_options[] = array( "name" => __("Select Menu Font", "Avada"),
			"desc" => __("Select a font family for navigation", "Avada"),
			"id" => "google_nav",
			"std" => "Antic Slab",
			"type" => "select",
			"options" => $google_fonts);

		$of_options[] = array( "name" => __("Select Headings Font", "Avada"),
			"desc" => __("Select a font family for headings", "Avada"),
			"id" => "google_headings",
			"std" => "Antic Slab",
			"type" => "select",
			"options" => $google_fonts);

		$of_options[] = array( "name" => __("Select Footer Headings Font", "Avada"),
			"desc" => __("Select a font family for footer headings", "Avada"),
			"id" => "google_footer_headings",
			"std" => "PT Sans",
			"type" => "select",
			"options" => $google_fonts);

		$of_options[] = array( "name" => __("Select Button Font", "Avada"),
			"desc" => __("Select a font family for button", "Avada"),
			"id" => "google_button",
			"std" => "PT Sans",
			"type" => "select",
			"options" => $google_fonts);

		$of_options[] = array( "name" => __("Google Font Settings", "Avada"),
			"desc" => __("Adjust the settings below to load different character sets and types for fonts. More character sets and types equals to slower page load. Please read <a href='http://theme-fusion.com/?p=275938'>How to configure google web fonts settings</a> for more info.", "Avada"),
			"id" => "gfont_settings",
			"std" => "400,400italic,700,700italic&subset=latin",
			"type" => "text");

	   $of_options[] = array( "name" => __("Google Fonts", "Avada"),
			"desc" => "",
			"id" => "google_fonts_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Google Fonts", "Avada") . "</h3><p style='margin-bottom:0;'>" . __("This will override standard font options.", "Avada" ) . "</p>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Standard Fonts", "Avada"),
			"desc" => "",
			"id" => "standard_fonts_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Standard Fonts", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Select Body Font Family", "Avada"),
			"desc" => __("Select a font family for body text", "Avada"),
			"id" => "standard_body",
			"std" => "",
			"type" => "select",
			"options" => $standard_fonts);

		$of_options[] = array( "name" => __("Select Menu Font Family", "Avada"),
			"desc" => __("Select a font family for menu / navigation", "Avada"),
			"id" => "standard_nav",
			"std" => "",
			"type" => "select",
			"options" => $standard_fonts);

		$of_options[] = array( "name" => __("Select Headings Font Family", "Avada"),
			"desc" => __("Select a font family for headings", "Avada"),
			"id" => "standard_headings",
			"std" => "",
			"type" => "select",
			"options" => $standard_fonts);

		$of_options[] = array( "name" => __("Select Footer Headings Font Family", "Avada"),
			"desc" => __("Select a font family for footer headings", "Avada"),
			"id" => "standard_footer_headings",
			"std" => "",
			"type" => "select",
			"options" => $standard_fonts);

		$of_options[] = array( "name" => __("Select Button Font Family", "Avada"),
			"desc" => __("Select a font family for button", "Avada"),
			"id" => "standard_button",
			"std" => "",
			"type" => "select",
			"options" => $standard_fonts);

		$of_options[] = array( "name" => __("Standard Fonts", "Avada"),
			"desc" => "",
			"id" => "standard_fonts_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Standard Fonts", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Font Sizes", "Avada"),
			"desc" => "",
			"id" => "font_size_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Font Sizes", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");


		$of_options[] = array( 	"name" => __("Body Font Size", "Avada"),
						"desc" 		=> __("In pixels, default is 13", "Avada"),
						"id" 		=> "body_font_size",
						"std" 		=> "13",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Main Menu Font Size", "Avada"),
			"desc" => __("In pixels, default is 14", "Avada"),
			"id" => "nav_font_size",
			"std" => "14",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Main Menu Dropdown Font Size", "Avada"),
			"desc" => __("In pixels, default is 13", "Avada"),
			"id" => "nav_dropdown_font_size",
			"std" => "13",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Secondary Menu & Top Contact Info Font Size", "Avada"),
			"desc" => __("In pixels, default is 12", "Avada"),
			"id" => "snav_font_size",
			"std" => "12",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Side Menu Font Size", "Avada"),
			"desc" => __("In pixels, default is 14", "Avada"),
			"id" => "side_nav_font_size",
			"std" => "14",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( 	"name" => __("Mobile Menu Font Size", "Avada"),
						"desc" 		=> __("In pixels, default is 12", "Avada"),
						"id" 		=> "mobile_menu_font_size",
						"std" 		=> "12",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Breadcrumbs Font Size", "Avada"),
			"desc" => __("In pixels, default is 10", "Avada"),
			"id" => "breadcrumbs_font_size",
			"std" => "10",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Sidebar Widget Heading Font Size", "Avada"),
			"desc" => __("In pixels, default is 13", "Avada"),
			"id" => "sidew_font_size",
			"std" => "13",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Sliding Bar Widget Heading Font Size", "Avada"),
			"desc" => __("In pixels, default is 13", "Avada"),
			"id" => "slidingbar_font_size",
			"std" => "13",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Footer Widget Heading Font Size", "Avada"),
			"desc" => __("In pixels, default is 13", "Avada"),
			"id" => "footw_font_size",
			"std" => "13",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Copyright Font Size", "Avada"),
			"desc" => __("In pixels, default is 12", "Avada"),
			"id" => "copyright_font_size",
			"std" => "12",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Size H1", "Avada"),
			"desc" => __("In pixels, default is 34", "Avada"),
			"id" => "h1_font_size",
			"std" => "34",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Size H2", "Avada"),
			"desc" => __("In pixels, default is 18", "Avada"),
			"id" => "h2_font_size",
			"std" => "18",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Size H3", "Avada"),
			"desc" => __("In pixels, default is 16", "Avada"),
			"id" => "h3_font_size",
			"std" => "16",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Size H4", "Avada"),
			"desc" => __("In pixels, default is 13", "Avada"),
			"id" => "h4_font_size",
			"std" => "13",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Size H5", "Avada"),
			"desc" => __("In pixels, default is 12", "Avada"),
			"id" => "h5_font_size",
			"std" => "12",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Size H6", "Avada"),
			"desc" => __("In pixels, default is 11", "Avada"),
			"id" => "h6_font_size",
			"std" => "11",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Post Titles Font Size", "Avada"),
			"desc" => __("Controls the font size of all post titles. In pixels, default is 18", "Avada"),
			"id" => "post_titles_font_size",
			"std" => "18",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Post Titles Extras Font Size", "Avada"),
			"desc" => __("Controls Comment, Related Posts and Author Titles. H3 heading. In pixels, default is 18", "Avada"),
			"id" => "post_titles_extras_font_size",
			"std" => "18",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Header Tagline Font Size", "Avada"),
			"desc" => __("In pixels, default is 16", "Avada"),
			"id" => "tagline_font_size",
			"std" => "16",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Meta Data Font Size", "Avada"),
			"desc" => __("In pixels, default is 12", "Avada"),
			"id" => "meta_font_size",
			"std" => "12",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Page Title Font Size", "Avada"),
			"desc" => __("In pixels, default is 18", "Avada"),
			"id" => "page_title_font_size",
			"std" => "18",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Page Title Subheader Font Size", "Avada"),
			"desc" => __("In pixels, default is 14", "Avada"),
			"id" => "page_title_subheader_font_size",
			"std" => "14",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Pagination Font Size", "Avada"),
			"desc" => __("In pixels, default is 12", "Avada"),
			"id" => "pagination_font_size",
			"std" => "12",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("WooCommerce Icon Font Size", "Avada"),
			"desc" => __("In pixels, default is 12", "Avada"),
			"id" => "woo_icon_font_size",
			"std" => "12",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);


		$of_options[] = array( "name" => __("Font Size", "Avada"),
			"desc" => "",
			"id" => "font_size_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Font Sizes", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Font Line Heights", "Avada"),
			"desc" => "",
			"id" => "font_line_heights_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Font Line Heights", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Body Font Line Height", "Avada"),
			"desc" => __("In pixels, default is 20", "Avada"),
			"id" => "body_font_lh",
			"std" => "20",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Line Height H1", "Avada"),
			"desc" => __("In pixels, default is 48", "Avada"),
			"id" => "h1_font_lh",
			"std" => "48",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Line Height H2", "Avada"),
			"desc" => __("In pixels, default is 27", "Avada"),
			"id" => "h2_font_lh",
			"std" => "27",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Line Height H3", "Avada"),
			"desc" => __("In pixels, default is 24", "Avada"),
			"id" => "h3_font_lh",
			"std" => "24",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Line Height H4", "Avada"),
			"desc" => __("In pixels, default is 20", "Avada"),
			"id" => "h4_font_lh",
			"std" => "20",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Line Height H5", "Avada"),
			"desc" => __("In pixels, default is 18", "Avada"),
			"id" => "h5_font_lh",
			"std" => "18",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading Font Line Height H6", "Avada"),
			"desc" => __("In pixels, default is 17", "Avada"),
			"id" => "h6_font_lh",
			"std" => "17",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Post Titles Line Height H2", "Avada"),
			"desc" => __("H2 Heading. In pixels, default is 27", "Avada"),
			"id" => "post_titles_font_lh",
			"std" => "27",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Secondary Menu Line Height", "Avada"),
			"desc" => __("In pixels, default is 44", "Avada"),
			"id" => "sec_menu_lh",
			"std" => "44",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Font Line Heights", "Avada"),
			"desc" => "",
			"id" => "font_line_heights_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Font Line Heights", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Font Weights", "Avada"),
			"desc" => "",
			"id" => "font_weights_wrapper",
			"std" => sprintf( "<h3 style='margin: 0;'>%s</h3>", __("Font Weights", "Avada") ),
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Font Weights Info", "Avada"),
			"desc" => "",
			"id" => "font_weights_description",
			"std" => "<ul class='list'><li>" . __("If you use a custom font, the font weight will correspond to the font weight of the uploaded files, thus these settings do not apply.</li><li>If you use a google font, make sure to load the font weight in 'Google Font Settings' field that corresponds to the one in parenthesis here.</li><li>Browser standard fonts in general support only 'Normal (400)' and 'Bold (700)' font weights.", "Avada") . "</li></ul>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Select Body Font Weight", "Avada"),
			"desc" => __("Select a font weight for the body font. ", "Avada"),
			"id" => "font_weight_body",
			"std" => "400",
			"type" => "select",
			"options" => $font_weights,
		);

		$of_options[] = array( "name" => __("Select Menu Font Weight", "Avada"),
			"desc" => __("Select a font weight of the menu font.", "Avada"),
			"id" => "font_weight_menu",
			"std" => "400",
			"type" => "select",
			"options" => $font_weights,
		);

		$of_options[] = array( "name" => __("Select Headings Font Weight", "Avada"),
			"desc" => __("Select a font weight for the headings font.", "Avada"),
			"id" => "font_weight_headings",
			"std" => "400",
			"type" => "select",
			"options" => $font_weights,
		);

		$of_options[] = array( "name" => __("Select Footer Headings Font Weight", "Avada"),
			"desc" => __("Select a font weight for the footer headings font.", "Avada"),
			"id" => "font_weight_footer_headings",
			"std" => "400",
			"type" => "select",
			"options" => $font_weights,
		);

		$of_options[] = array( "name" => __("Select Button Font Weight", "Avada"),
			"desc" => __("Select a font weight for the button font.", "Avada"),
			"id" => "font_weight_button",
			"std" => "700",
			"type" => "select",
			"options" => $font_weights,
		);

		$of_options[] = array( "name" => __("Font Weights", "Avada"),
			"desc" => "",
			"id" => "font_weights_wrapper",
			"std" => sprintf( "<h3 style='margin: 0;'>%s</h3>", __("Font Weights", "Avada") ),
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Font Letter Spacing", "Avada"),
			"desc" => "",
			"id" => "font_letter_spacing_wrapper",
			"std" => sprintf( "<h3 style='margin: 0;'>%s</h3>", __("Font Letter Spacing", "Avada") ),
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Heading H1 Letter Spacing", "Avada"),
			"desc" => __("Controls the letter spacing of h1 headings. In pixels, ex: 2", "Avada"),
			"id" => "h1_font_ls",
			"std" => "0",
						"min" 		=> "0",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading H2 Letter Spacing", "Avada"),
			"desc" => __("Controls the letter spacing of h2 headings. In pixels, ex: 2", "Avada"),
			"id" => "h2_font_ls",
			"std" => "0",
						"min" 		=> "0",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading H3 Letter Spacing", "Avada"),
			"desc" => __("Controls the letter spacing of h3 headings. In pixels, ex: 2", "Avada"),
			"id" => "h3_font_ls",
			"std" => "0",
						"min" 		=> "0",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading H4 Letter Spacing", "Avada"),
			"desc" => __("Controls the letter spacing of h4 headings. In pixels, ex: 2", "Avada"),
			"id" => "h4_font_ls",
			"std" => "0",
						"min" 		=> "0",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading H5 Letter Spacing", "Avada"),
			"desc" => __("Controls the letter spacing of h5 headings. In pixels, ex: 2", "Avada"),
			"id" => "h5_font_ls",
			"std" => "0",
						"min" 		=> "0",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Heading H6 Letter Spacing", "Avada"),
			"desc" => __("Controls the letter spacing of h6 headings. In pixels, ex: 2", "Avada"),
			"id" => "h6_font_ls",
			"std" => "0",
						"min" 		=> "0",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Menu Letter Spacing", "Avada"),
			"desc" => __("Controls the letter spacing of menu text. In pixels, ex: 2", "Avada"),
			"id" => "menu_font_ls",
			"std" => "0",
						"min" 		=> "0",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Button Letter Spacing", "Avada"),
			"desc" => __("Controls the letter spacing of button text. In pixels, ex: 2", "Avada"),
			"id" => "button_font_ls",
			"std" => "0",
						"min" 		=> "0",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Font Letter Spacing", "Avada"),
			"desc" => "",
			"id" => "font_letter_spacing_wrapper",
			"std" => sprintf( "<h3 style='margin: 0;'>%s</h3>", __("Font Letter Spacing", "Avada") ),
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Font Margins", "Avada"),
			"desc" => "",
			"id" => "font_margins_wrapper",
			"std" => sprintf( "<h3 style='margin: 0;'>%s</h3>", __("Font Margins", "Avada") ),
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("H1 Top Margin", "Avada"),
			"desc" => __('In ems, default is 0.67', 'Avada'),
			"id" => "h1_top_margin",
			"std" => "0.67",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H1 Bottom Margin", "Avada"),
			"desc" => __('In ems, default is 0.67', 'Avada'),
			"id" => "h1_bottom_margin",
			"std" => "0.67",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H2 Top Margin", "Avada"),
			"desc" => __('In ems, default is 0', 'Avada'),
			"id" => "h2_top_margin",
			"std" => "0",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H2 Bottom Margin", "Avada"),
			"desc" => __('In ems, default is 1.1', 'Avada'),
			"id" => "h2_bottom_margin",
			"std" => "1.1",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H3 Top Margin", "Avada"),
			"desc" => __('In ems, default is 1', 'Avada'),
			"id" => "h3_top_margin",
			"std" => "1",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H3 Bottom Margin", "Avada"),
			"desc" => __('In ems, default is 1', 'Avada'),
			"id" => "h3_bottom_margin",
			"std" => "1",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H4 Top Margin", "Avada"),
			"desc" => __('In ems, default is 1.33', 'Avada'),
			"id" => "h4_top_margin",
			"std" => "1.33",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H4 Bottom Margin", "Avada"),
			"desc" => __('In ems, default is 1.33', 'Avada'),
			"id" => "h4_bottom_margin",
			"std" => "1.33",
			"type" => "text"
				);


		$of_options[] = array( "name" => __("H5 Top Margin", "Avada"),
			"desc" => __('In ems, default is 1.67', 'Avada'),
			"id" => "h5_top_margin",
			"std" => "1.67",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H5 Bottom Margin", "Avada"),
			"desc" => __('In ems, default is 1.67', 'Avada'),
			"id" => "h5_bottom_margin",
			"std" => "1.67",
			"type" => "text"
				);


		$of_options[] = array( "name" => __("H6 Top Margin", "Avada"),
			"desc" => __('In ems, default is 2.33', 'Avada'),
			"id" => "h6_top_margin",
			"std" => "2.33",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("H6 Bottom Margin", "Avada"),
			"desc" => __('In ems, default is 2.33', 'Avada'),
			"id" => "h6_bottom_margin",
			"std" => "2.33",
			"type" => "text"
				);

		$of_options[] = array( "name" => __("Font Margins", "Avada"),
			"desc" => "",
			"id" => "font_margins_wrapper",
			"std" => sprintf( "<h3 style='margin: 0;'>%s</h3>", __("Font Margins", "Avada") ),
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Styling", "Avada"),
			"id" => "heading_styling",
			"type" => "heading");

		$of_options[] = array( "name" => __("Select Theme Skin", "Avada"),
			"desc" => __("Select a skin, all color options will automatically change to the defined skin.", "Avada"),
			"id" => "scheme_type",
			"std" => "Light",
			"type" => "select",
			"options" => array('Light' => 'Light', 'Dark' => 'Dark'));

		$of_options[] = array( "name" => __("Predefined Color Scheme", "Avada"),
			"desc" => __("Select a scheme, all color options will automatically change to the defined scheme.", "Avada"),
			"id" => "color_scheme",
			"std" => "Green",
			"type" => "select",
			"options" => array('Red' => 'Red', 'Light Red' => 'Light Red', 'Blue' => 'Blue', 'Light Blue' => 'Light Blue', 'Green' => 'Green', 'Dark Green' => 'Dark Green', 'Orange' => 'Orange', 'Pink' => 'Pink', 'Brown' => 'Brown', 'Light Grey' => 'Light Grey'));

	   $of_options[] = array( "name" => __("Background Colors", "Avada"),
			"desc" => "",
			"id" => "bg_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Background Colors", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Primary Color", "Avada"),
			"desc" => __("Controls several items, ex: link hovers, highlights, and more.", "Avada"),
			"id" => "primary_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Sliding Bar Background Color and Opacity", "Avada"),
			"desc" => __("Controls the background color and opacity of the top sliding bar. Opacity ranges between 0 (transparent) and 1 (opaque). ex: .4", "Avada"),
			"id" => "slidingbar_bg_color",
			"std" => array(
						'color' => "#363839",
						'opacity' => '1'
					 ),
			"type" => "backgroundcolor");

		$of_options[] = array( "name" => __("Header Background Color and Opacity", "Avada"),
			"desc" => __("Controls the background color and opacity for the header. Opacity only works with header top position and ranges between 0 (transparent) and 1 (opaque). ex: .4", "Avada"),
			"id" => "header_bg_color",
			"std" => array(
						'color' => "#ffffff",
						'opacity' => '1'
					 ),
			"type" => "backgroundcolor");

		$of_options[] = array( "name" => __("Sticky Header Background Color and Opacity", "Avada"),
			"desc" => __("Controls the background color for the sticky header. Opacity ranges between 0 (transparent) and 1 (opaque). ex: .4", "Avada"),
			"id" => "header_sticky_bg_color",
			"std" => array(
						'color' => "#ffffff",
						'opacity' => '0.97'
					 ),
			"type" => "backgroundcolor");


		$of_options[] = array( "name" => __("Header Border Color", "Avada"),
			"desc" => __("Controls the border colors for the header. If using left or right header position it controls the menu divider lines.", "Avada"),
			"id" => "header_border_color",
			"std" => "#e5e5e5",
			"type" => "color");

		$of_options[] = array( "name" => __("Header Top Background Color", "Avada"),
			"desc" => __("Controls the background color of the top header section used in Headers 2-5.", "Avada"),
			"id" => "header_top_bg_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Page Title Bar Background Color", "Avada"),
			"desc" => __("Select a color for the page title bar background.", "Avada"),
			"id" => "page_title_bg_color",
			"std" => "#F6F6F6",
			"type" => "color");

		$of_options[] = array( "name" => __("Page Title Bar Borders Color", "Avada"),
			"desc" => __("Select a color for the page title bar borders.", "Avada"),
			"id" => "page_title_border_color",
			"std" => "#d2d3d4",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Background Color", "Avada"),
			"desc" => __("Controls the background color of the main content area.", "Avada"),
			"id" => "content_bg_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Sidebar Background Color", "Avada"),
			"desc" => __("Controls the background color of the sidebar.", "Avada"),
			"id" => "sidebar_bg_color",
			"std" => "transparent",
			"type" => "color");

		$of_options[] = array( "name" => __("Sidebar Widget Title Background Color", "Avada"),
			"desc" => __("Controls the background color of the sidebar widget title.", "Avada"),
			"id" => "sidebar_widget_bg_color",
			"std" => "transparent",
			"type" => "color");

		$of_options[] = array( "name" => __("Footer Background Color", "Avada"),
			"desc" => __("Controls the background color of the footer.", "Avada"),
			"id" => "footer_bg_color",
			"std" => "#363839",
			"type" => "color");

		$of_options[] = array( "name" => __("Footer Border Color", "Avada"),
			"desc" => __("Controls the border colors for the footer.", "Avada"),
			"id" => "footer_border_color",
			"std" => "#e9eaee",
			"type" => "color");

		$of_options[] = array( "name" => __("Copyright Background Color", "Avada"),
			"desc" => __("Controls the background color of the footer copyright.", "Avada"),
			"id" => "copyright_bg_color",
			"std" => "#282a2b",
			"type" => "color");

		$of_options[] = array( "name" => __("Copyright Border Color", "Avada"),
			"desc" => __("Controls the border colors for the footer copyright.", "Avada"),
			"id" => "copyright_border_color",
			"std" => "#4b4c4d",
			"type" => "color");

	   $of_options[] = array( "name" => __("Background Colors", "Avada"),
			"desc" => "",
			"id" => "bg_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Background Colors", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Element Colors", "Avada"),
			"desc" => "",
			"id" => "element_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Element Colors", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Rollover Image Gradient Top Color and Opacity", "Avada"),
			"desc" => __("Controls the top color of the image rollover gradients. Opacity ranges between 0 (transparent) and 1 (opaque). ex: .4", "Avada"),
			"id" => "image_gradient_top_color",
			"std" => array(
						'color' => "#a0ce4e",
						'opacity' => '0.8'
					 ),
			"type" => "backgroundcolor");

		$of_options[] = array( "name" => __("Rollover Image Gradient Bottom Color", "Avada"),
			"desc" => __("Controls the bottom color of the image rollover gradients.", "Avada"),
			"id" => "image_gradient_bottom_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Rollover Image Element Color", "Avada"),
			"desc" => __("This option controls the color of image rollover text and the icon circle backgrounds.", "Avada"),
			"id" => "image_rollover_text_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Rollover Image Icon Color", "Avada"),
			"desc" => __("Controls the color of the icons in the rollover.", "Avada"),
			"id" => "image_rollover_icon_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Sliding Bar Toggle Icon Color", "Avada"),
			"desc" => __("Controls the icon color of the sliding bar toggle.", "Avada"),
			"id" => "slidingbar_toggle_icon_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Sliding Bar Item Divider Color", "Avada"),
			"desc" => __("Controls the divider color in the sliding bar.", "Avada"),
			"id" => "slidingbar_divider_color",
			"std" => "#282A2B",
			"type" => "color");

		$of_options[] = array( "name" => __("Footer Widget Divider Color", "Avada"),
			"desc" => __("Controls the divider color in the footer.", "Avada"),
			"id" => "footer_divider_color",
			"std" => "#505152",
			"type" => "color");

		$of_options[] = array( "name" => __("Form Background Color", "Avada"),
			"desc" => __("Controls the background color of form fields.", "Avada"),
			"id" => "form_bg_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Form Text Color", "Avada"),
			"desc" => __("Controls the text color for forms.", "Avada"),
			"id" => "form_text_color",
			"std" => "#aaa9a9",
			"type" => "color");

		$of_options[] = array( "name" => __("Form Border Color", "Avada"),
			"desc" => __("Controls the border color of form fields.", "Avada"),
			"id" => "form_border_color",
			"std" => "#d2d2d2",

			"type" => "color");

		$of_options[] = array( "name" => __("Grid Box Color", "Avada"),
			"desc" => __("Controls blog grid, timeline, portfolio boxed items and Woocommerce post box background color.", "Avada"),
			"id" => "timeline_bg_color",
			"std" => "transparent",
			"type" => "color");

		$of_options[] = array( "name" => __("Grid Element Color", "Avada"),
			"desc" => __("Controls blog grid, timeline, portfolio boxed items, Woocommerce post box border, divider lines, date box and border, timeline dots, timeline icon, timeline arrow.", "Avada"),
			"id" => "timeline_color",
			"std" => "#ebeaea",
			"type" => "color");

		$of_options[] = array( "name" => __("Load More Posts Button Color", "Avada"),
			"desc" => __("Controls the background color of the load more button for ajax post loading.", "Avada"),
			"id" => "load_more_posts_button_bg_color",
			"std" => "#ebeaea",
			"type" => "color");

		$of_options[] = array( "name" => __("Woo Quantity Box Background Color", "Avada"),
			"desc" => __("Controls the background color of the woocommerce quantity box.", "Avada"),
			"id" => "qty_bg_color",
			"std" => "#fbfaf9",
			"type" => "color");

		$of_options[] = array( "name" => __("Woo Quantity Box Hover Background Color", "Avada"),
			"desc" => __("Controls the hover color of the woocommerce quantity box.", "Avada"),
			"id" => "qty_bg_hover_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("WooCommerce Dropdown Background Color", "Avada"),
			"desc" => __("Controls the background color.", "Avada"),
			"id" => "woo_dropdown_bg_color",
			"std" => "#fbfaf9",
			"type" => "color");

		$of_options[] = array( "name" => __("WooCommerce Dropdown Text Color", "Avada"),
			"desc" => __("Controls the color of the text and icons.", "Avada"),
			"id" => "woo_dropdown_text_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("WooCommerce Dropdown Border Color", "Avada"),
			"desc" => __("Controls the border color.", "Avada"),
			"id" => "woo_dropdown_border_color",
			"std" => "#dbdbdb",
			"type" => "color");

	   $of_options[] = array( "name" => __("Element Colors", "Avada"),
			"desc" => "",
			"id" => "element_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Element Colors", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Layout Options", "Avada"),
			"desc" => "",
			"id" => "element_options_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Layout Options", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Page Content Top Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "main_top_padding",
			"std" => "55px",
			"type" => "text");

		$of_options[] = array( "name" => __("Page Content Bottom Padding", "Avada"),
			"desc" => __("In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "main_bottom_padding",
			"std" => "40px",
			"type" => "text");

		$of_options[] = array( "name" => __("100% Width Left/Right Padding", "Avada"),
			"desc" => __("This option controls the left/right padding for page content when using 100% site width or 100% width page template.  In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "hundredp_padding",
			"std" => "30px",
			"type" => "text");

		$of_options[] = array( "name" => __("Sidebar Padding", "Avada"),
			"desc" => __("Enter a pixel or percentage based value, ex: 5px or 5%", "Avada"),
			"id" => "sidebar_padding",
			"std" => "0",
			"type" => "text");

		$of_options[] = array( "name" => __("Column Top Margin", "Avada"),
			"desc" => __("Controls the top margin for all column sizes. In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "col_top_margin",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Column Bottom Margin", "Avada"),
			"desc" => __("Controls the bottom margin for all column sizes. In pixels or percentage, ex: 10px or 10%.", "Avada"),
			"id" => "col_bottom_margin",
			"std" => "20px",
			"type" => "text");

		$of_options[] = array( "name" => __("Disable Sliding Bar Text Shadow", "Avada"),
			"desc" => __("Check to disable the text shadow in the Sliding Bar.", "Avada"),
			"id" => "slidingbar_text_shadow",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Rollover Text Shadow", "Avada"),
			"desc" => __("Check to disable the text shadow on rollovers.", "Avada"),
			"id" => "rollover_text_shadow",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Footer Text Shadow", "Avada"),
			"desc" => __("Check to disable the text shadow in the footer.", "Avada"),
			"id" => "footer_text_shadow",
			"std" => 1,
			"type" => "checkbox");

	   $of_options[] = array( "name" => __("Layout Options", "Avada"),
			"desc" => "",
			"id" => "element_options_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Layout Options", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Font Colors", "Avada"),
			"desc" => "",
			"id" => "font_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Font Colors", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Header Tagline Font Color", "Avada"),
			"desc" => __("Controls the text color of the header tagline font.", "Avada"),
			"id" => "tagline_font_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Page Title Font Color", "Avada"),
			"desc" => __("Controls the text color of the page title font.", "Avada"),
			"id" => "page_title_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Heading 1 (H1) Font Color", "Avada"),
			"desc" => __("Controls the text color of H1 headings.", "Avada"),
			"id" => "h1_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Heading 2 (H2) Font Color", "Avada"),
			"desc" => __("Controls the text color of H2 headings.", "Avada"),
			"id" => "h2_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Heading 3 (H3) Font Color", "Avada"),
			"desc" => __("Controls the text color of H3 headings.", "Avada"),
			"id" => "h3_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Heading 4 (H4) Font Color", "Avada"),
			"desc" => __("Controls the text color of H4 headings.", "Avada"),
			"id" => "h4_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Heading 5 (H5) Font Color", "Avada"),
			"desc" => __("Controls the text color of H5 headings.", "Avada"),
			"id" => "h5_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Heading 6 (H6) Font Color", "Avada"),
			"desc" => __("Controls the text color of H6 headings.", "Avada"),
			"id" => "h6_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Body Text Color", "Avada"),
			"desc" => __("Controls the text color of body font.", "Avada"),
			"id" => "body_text_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Link Color", "Avada"),
			"desc" => __("Controls the color of all text links as well as the '>' in certain areas.", "Avada"),
			"id" => "link_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Breadcrumbs Text Color", "Avada"),
			"desc" => __("Controls the text color of the breadcrumb font.", "Avada"),
			"id" => "breadcrumbs_text_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Sliding Bar Headings Color", "Avada"),
			"desc" => __("Controls the text color of the sliding bar heading font.", "Avada"),
			"id" => "slidingbar_headings_color",
			"std" => "#DDDDDD",
			"type" => "color");

		$of_options[] = array( "name" => __("Sliding Bar Font Color", "Avada"),
			"desc" => __("Controls the font color of the sliding bar font.", "Avada"),
			"id" => "slidingbar_text_color",
			"std" => "#8C8989",
			"type" => "color");

		$of_options[] = array( "name" => __("Sliding Bar Link Color", "Avada"),
			"desc" => __("Controls the text color of the sliding bar link font.", "Avada"),
			"id" => "slidingbar_link_color",
			"std" => "#BFBFBF",
			"type" => "color");

		$of_options[] = array( "name" => __("Sidebar Widget Headings Color", "Avada"),
			"desc" => __("Controls the text color of the sidebar widget headings.", "Avada"),
			"id" => "sidebar_heading_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Footer Headings Color", "Avada"),
			"desc" => __("Controls the text color of the footer heading font.", "Avada"),
			"id" => "footer_headings_color",
			"std" => "#DDDDDD",
			"type" => "color");

		$of_options[] = array( "name" => __("Footer Font Color", "Avada"),
			"desc" => __("Controls the text color of the footer font.", "Avada"),
			"id" => "footer_text_color",
			"std" => "#8C8989",
			"type" => "color");

		$of_options[] = array( "name" => __("Footer Link Color", "Avada"),
			"desc" => __("Controls the text color of the footer link font.", "Avada"),
			"id" => "footer_link_color",
			"std" => "#BFBFBF",
			"type" => "color");

	   $of_options[] = array( "name" => __("Font Colors", "Avada"),
			"desc" => "",
			"id" => "font_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Font Colors", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Main Menu Colors", "Avada"),
			"desc" => "",
			"id" => "main_menu_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Main Menu Colors", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Main Menu Background Color For Header 4 & 5", "Avada"),
			"desc" => __("Controls the background color of the menu when using header 4 or 5.", "Avada"),
			"id" => "menu_h45_bg_color",
			"std" => "#FFFFFF",
			"type" => "color");

		$of_options[] = array( "name" => __("Main Menu Font Color - First Level", "Avada"),
			"desc" => __("Controls the text color of first level menu items.", "Avada"),
			"id" => "menu_first_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Main Menu Font Hover Color - First Level", "Avada"),
			"desc" => __("Controls the main menu hover, hover border, dropdown border color & active menu item.", "Avada"),
			"id" => "menu_hover_first_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Main Menu Background Color - Sublevels", "Avada"),
			"desc" => __("Controls the color of the menu sublevel background.", "Avada"),
			"id" => "menu_sub_bg_color",
			"std" => "#f2efef",
			"type" => "color");

		$of_options[] = array( "name" => __("Main Menu Background Hover Color - Sublevels", "Avada"),
			"desc" => __("Controls the hover color of the menu sublevel background.", "Avada"),
			"id" => "menu_bg_hover_color",
			"std" => "#f8f8f8",
			"type" => "color");

		$of_options[] = array( "name" => __("Main Menu Font Color - Sublevels", "Avada"),
			"desc" => __("Controls the color of the menu font sublevels.", "Avada"),
			"id" => "menu_sub_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Main Menu Separator - Sublevels", "Avada"),
			"desc" => __("Controls the color of the menu separator sublevels.", "Avada"),
			"id" => "menu_sub_sep_color",
			"std" => "#dcdadb",
			"type" => "color");

		$of_options[] = array( "name" => __("Woo Cart Menu Background Color", "Avada"),
			"desc" => __("Controls the bottom section background color of the woocommerce cart dropdown.", "Avada"),
			"id" => "woo_cart_bg_color",
			"std" => "#fafafa",
			"type" => "color");

	   $of_options[] = array( "name" => __("Main Menu Colors", "Avada"),
			"desc" => "",
			"id" => "main_menu_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Main Menu Colors", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Secondary Menu Colors", "Avada"),
			"desc" => "",
			"id" => "menu_colors_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Secondary Menu Colors", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Secondary Menu Font Color - First Level & Contact Info", "Avada"),
			"desc" => __("Controls the color of the secondary menu first level and contact info font.", "Avada"),
			"id" => "snav_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Secondary Menu Divider Color - First Level", "Avada"),
			"desc" => __("Controls the divider color of the first level secondary menu.", "Avada"),
			"id" => "header_top_first_border_color",
			"std" => "#e5e5e5",
			"type" => "color");

		$of_options[] = array( "name" => __("Secondary Menu Background Color - Sublevels", "Avada"),
			"desc" => __("Controls the background color of the secondary menu sublevels.", "Avada"),
			"id" => "header_top_sub_bg_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Secondary Menu Font Color - Sublevels", "Avada"),
			"desc" => __("Controls the text color of the secondary menu font sublevels.", "Avada"),
			"id" => "header_top_menu_sub_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Secondary Menu Hover Background Color - Sublevels", "Avada"),
			"desc" => __("Controls the hover color of the secondary menu background sublevels.", "Avada"),
			"id" => "header_top_menu_bg_hover_color",
			"std" => "#fafafa",
			"type" => "color");

		$of_options[] = array( "name" => __("Secondary Menu Hover Font Color - Sublevels", "Avada"),
			"desc" => __("Controls the hover text color of the secondary menu font sublevels.", "Avada"),
			"id" => "header_top_menu_sub_hover_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Secondary Menu Border  - Sublevels", "Avada"),
			"desc" => __("Controls the border color of the secondary menu sublevels.", "Avada"),
			"id" => "header_top_menu_sub_sep_color",
			"std" => "#e5e5e5",
			"type" => "color");

		$of_options[] = array( "name" => __("Secondary Menu Colors", "Avada"),
			"desc" => "",
			"id" => "menu_colors_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Secondary Menu Colors", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Mobile Menu Colors", "Avada"),
			"desc" => "",
			"id" => "mobile_menu_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Mobile Menu Colors", "Avada"). "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Mobile Header Background Color", "Avada"),
			"desc" => __("Controls the background color of the header on mobile devices.", "Avada"),
			"id" => "mobile_header_bg_color",
			"std" => '#ffffff',
			"type" => "color");

		$of_options[] = array( "name" => __("Mobile Menu Background Color", "Avada"),
			"desc" => __("Controls the background color of the mobile menu box and dropdown.", "Avada"),
			"id" => "mobile_menu_background_color",
			"std" => "#f9f9f9",
			"type" => "color");

		$of_options[] = array( "name" => __("Mobile Menu Border Color", "Avada"),
			"desc" => __("Controls the border and divider of the mobile menu.", "Avada"),
			"id" => "mobile_menu_border_color",
			"std" => "#dadada",
			"type" => "color");

		$of_options[] = array( "name" => __("Mobile Menu Hover Color", "Avada"),
			"desc" => __("Controls the background hover color of the mobile menu items.", "Avada"),
			"id" => "mobile_menu_hover_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Mobile Menu Font Color", "Avada"),
			"desc" => __("Controls the text color of mobile menu items.", "Avada"),
			"id" => "mobile_menu_font_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Mobile Menu Toggle Color", "Avada"),
			"desc" => __("Controls the color of the mobile menu toggle icon", "Avada"),
			"id" => "mobile_menu_toggle_color",
			"std" => ( isset( $smof_data['mobile_menu_border_color'] ) ) ? $smof_data['mobile_menu_border_color'] : "#dadada",
			"type" => "color");


	   $of_options[] = array( "name" => __("Mobile Menu Colors", "Avada"),
			"desc" => "",
			"id" => "mobile_menu_colors_wrapper",
			"std" => "<h3 style='margin: 0;'>" . __("Mobile Menu Colors", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Shortcodes", "Avada"),
			"id" => "heading_shortcode_styling",
			"type" => "heading");

		$of_options[] = array( "name" => __("Animation Offset", "Avada"),
			"desc" => __("Choose when the animation should start.", "Avada"),
			"id" => "animation_offset",
			"std" => 'top-into-view',
			"type" => "select",
			"options" => array(
					'top-into-view' 	=> 'Top of element hits bottom of viewport',
					'top-mid-of-view' 	=> 'Top of element hits middle of viewport',
					'bottom-in-view' 	=> 'Bottom of element enters viewport',
					)
			);

	   $of_options[] = array( "name" => __("Blog Shortcode", "Avada"),
			"desc" => "",
			"id" => "blog_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Blog Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Blog Date Box Color", "Avada"),
			"desc" => __("Controls the color of the date box in blog alternate and recent posts layouts.", "Avada"),
			"id" => "dates_box_color",
			"std" => "#eef0f2",
			"type" => "color");

	   $of_options[] = array( "name" => __("Blog Shortcode", "Avada"),
			"desc" => "",
			"id" => "blog_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Blog Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Button Shortcode", "Avada"),
			"desc" => "",
			"id" => "button_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Button Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Button Size", "Avada"),
			"desc" => __("Select the default button size.", "Avada"),
			"id" => "button_size",
			"std" => "Large",
			"type" => "select",
			"options" => array('Small' => 'Small', 'Medium' => 'Medium', 'Large' => 'Large', 'XLarge' => 'XLarge'));

		$of_options[] = array( "name" => __("Button Span", "Avada"),
			"desc" => __("Choose to have the button span the full width of its container.", "Avada"),
			"id" => "button_span",
			"std" => "no",
			"type" => "select",
			"options" => array('yes' => 'Yes', 'no' => 'No'));

		$of_options[] = array( "name" => __("Button Shape", "Avada"),
			"desc" => __("Select the default shape for buttons.", "Avada"),
			"id" => "button_shape",
			"std" => "Round",
			"type" => "select",
			"options" => array('Square' => 'Square', 'Round' => 'Round', 'Pill' => 'Pill'));

		$of_options[] = array( "name" => __("Button Type", "Avada"),
			"desc" => __("Select the default button type.", "Avada"),
			"id" => "button_type",
			"std" => "Flat",
			"type" => "select",
			"options" => array('Flat' => 'Flat', '3d' => '3d'));

		$of_options[] = array( "name" => __("Button Gradient Top Color", "Avada"),
			"desc" => __("Set the top color of the button background.", "Avada"),
			"id" => "button_gradient_top_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Button Gradient Bottom Color", "Avada"),
			"desc" => __("Set the bottom color of the button background or leave empty for solid color.", "Avada"),
			"id" => "button_gradient_bottom_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Button Gradient Top Hover Color", "Avada"),
			"desc" => __("Set the top hover color of the button background.", "Avada"),
			"id" => "button_gradient_top_color_hover",
			"std" => "#96c346",
			"type" => "color");

		$of_options[] = array( "name" => __("Button Gradient Bottom Hover Color", "Avada"),
			"desc" => __("Set the bottom hover color of the button background or leave empty for solid color. ", "Avada"),
			"id" => "button_gradient_bottom_color_hover",
			"std" => "#96c346",
			"type" => "color");

		$of_options[] = array( "name" => __("Button Accent Color", "Avada"),
			"desc" => __("This option controls the color of the button border, divider, text and icon.", "Avada"),
			"id" => "button_accent_color",
			"std" => "#fff",
			"type" => "color");

		$of_options[] = array( "name" => __("Button Accent Hover Color", "Avada"),
			"desc" => __("This option controls the hover color of the button border, divider, text and icon.", "Avada"),
			"id" => "button_accent_hover_color",
			"std" => "#fff",
			"type" => "color");

		$of_options[] = array( "name" => __("Button Bevel Color (3D Mode only)", "Avada"),
			"desc" => __("Controls the default bevel color of the buttons.", "Avada"),
			"id" => "button_bevel_color",
			"std" => "#54770F",
			"type" => "color");

		$of_options[] = array( "name" => __("Button Border Width", "Avada"),
			"desc" => __("Select the border width for buttons. Enter value in px. ex: 1px", "Avada"),
			"id" => "button_border_width",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Button Shortcode", "Avada"),
			"desc" => "",
			"id" => "button_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Button Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Carousel Shortcode", "Avada"),
			"desc" => "",
			"id" => "carousel_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Carousel Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Carousel Default Nav Box Color", "Avada"),
			"desc" => __("Controls the color of the default navigation box for carousel sliders.", "Avada"),
			"id" => "carousel_nav_color",
			"std" => "rgba(0,0,0,0.6)",
			"type" => "color");

		$of_options[] = array( "name" => __("Carousel Hover Nav Box Color", "Avada"),
			"desc" => __("Controls the color of the hover navigation box for carousel sliders.", "Avada"),
			"id" => "carousel_hover_color",
			"std" => "rgba(0,0,0,0.7)",
			"type" => "color");

		$of_options[] = array( "name" => __("Carousel Speed", "Avada"),
			"desc" => __("Controls the speed of all carousel elements.  ex: 1000 = 1 second.", "Avada"),
			"id" => "carousel_speed",
			"std" => "2500",
			"type" => "text");

		$of_options[] = array( "name" => __("Carousel Shortcode", "Avada"),
			"desc" => "",
			"id" => "carousel_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Carousel Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Checklist Shortcode", "Avada"),
			"desc" => "",
			"id" => "checklist_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Checklist Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Checklist Circle", "Avada"),
			"desc" => __("Check the box if you want to use circles on checklists.", "Avada"),
			"id" => "checklist_circle",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Checklist Circle Color", "Avada"),
			"desc" => __("Controls the color of the checklist circle.", "Avada"),
			"id" => "checklist_circle_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Checklist Icon Color", "Avada"),
			"desc" => __("Controls the color of the checklist icon.", "Avada"),
			"id" => "checklist_icons_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Checklist Shortcode", "Avada"),
			"desc" => "",
			"id" => "checklist_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Checklist Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Content Box Shortcode", "Avada"),
			"desc" => "",
			"id" => "cb_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Content Box Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Content Box Background Color", "Avada"),
			"desc" => __("Controls the color of the background for content boxes. Only use for 'icon-boxed' style. Leave transparent for other styles.", "Avada"),
			"id" => "content_box_bg_color",
			"std" => "transparent",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Box Title Font Size", "Avada"),
			"desc" => __("Controls the size of the title text. In pixels. Default is 18.", "Avada"),
			"id" => "content_box_title_size",
			"std" => "18",
			"type" => "text");

		$of_options[] = array( "name" => __("Content Box Title Font Color", "Avada"),
			"desc" => __("Controls the color of the title font.", "Avada"),
			"id" => "content_box_title_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Box Body Font Color", "Avada"),
			"desc" => __("Controls the color of the body font.", "Avada"),
			"id" => "content_box_body_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Box Icon Background", "Avada"),
			"desc" => __("Controls the background behind the icon.", "Avada"),
			"id" => "content_box_icon_circle",
			"std" => "yes",
			"type" => "select",
			"options" => array('yes' => 'Yes', 'no' => 'No'));

		$of_options[] = array( "name" => __("Content Box Icon Background Radius", "Avada"),
			"desc" => __("Choose the border radius of the icon background. In pixels (px), ex: 1px, or \"round\".", "Avada"),
			"id" => "content_box_icon_circle_radius",
			"std" => "round",
			"type" => "text");

		$of_options[] = array( "name" => __("Content Box Icon Color", "Avada"),
			"desc" => __("Controls the color of the content box icon.", "Avada"),
			"id" => "content_box_icon_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Box Icon Background Color", "Avada"),
			"desc" => __("Controls the background color of the content box icon.", "Avada"),
			"id" => "content_box_icon_bg_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Box Icon Background Inner Border Color", "Avada"),
			"desc" => __("Controls the inner border color of the content box icon border.", "Avada"),
			"id" => "content_box_icon_bg_inner_border_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Box Icon Background Inner Border Size", "Avada"),
			"desc" => __("Controls the inner border size of the content box icon border.", "Avada"),
			"id" => "content_box_icon_bg_inner_border_size",
			"std" => "1px",
			"type" => "text");

		$of_options[] = array( "name" => __("Content Box Icon Background Outer Border Color", "Avada"),
			"desc" => __("Controls the outer boreder color of the content box icon border.", "Avada"),
			"id" => "content_box_icon_bg_outer_border_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Box Icon Background Outer Border Size", "Avada"),
			"desc" => __("Controls the outer border size of the content box icon border.", "Avada"),
			"id" => "content_box_icon_bg_outer_border_size",
			"std" => "",
			"type" => "text");


		$of_options[] = array( "name" => __("Content Box Icon Font Size", "Avada"),
			"desc" => __("Controls the size of the icon. In pixels. Default is 21.", "Avada"),
			"id" => "content_box_icon_size",
			"std" => "21",
			"type" => "text");

		$of_options[] = array( "name" => __("Content Box Icon Hover Animation Type", "Avada"),
			"desc" => __("Controls the hover effect of the icon.", "Avada"),
			"id" => "content_box_icon_hover_type",
			"std" => "fade",
			"type" => "select",
			"options" => array('none' => __('None', 'Avada'), 'fade' => __('Fade', 'Avada'), 'slide' => __('Slide', 'Avada'), 'pulsate' => __('Pulsate', 'Avada')));

		$of_options[] = array( "name" => __("Content Box Hover Animation Accent Color", "Avada"),
			"desc" => __("Controls the accent color for the hover animation.", "Avada"),
			"id" => "content_box_hover_animation_accent_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Content Box Link Type", "Avada"),
			"desc" => __("Select the type of link that should show in the content box.", "Avada"),
			"id" => "content_box_link_type",
			"std" => "text",
			"type" => "select",
			"options" => array('text' => 'Text', 'button-bar' => 'Button Bar', 'button' => 'Button'));

		$of_options[] = array( "name" => __("Content Box Link Area", "Avada"),
			"desc" => __("Select which area the link will be assigned to.", "Avada"),
			"id" => "content_box_link_area",
			"std" => "link-icon",
			"type" => "select",
			"options" => array('link-icon' => 'Link+Icon', 'box' => 'Entire Content Box'));

		$of_options[] = array( "name" => __("Content Box Link Target", "Avada"),
			"desc" => __("_self = open in same window<br>_blank = open in new window. Select default for theme option selection.", "Avada"),
			"id" => "content_box_link_target",
			"std" => "_self",
			"type" => "select",
			"options" => array('_self' => '_self', '_blank' => '_blank'));

		$of_options[] = array( "name" => __("Content Box Margin Top", "Avada"),
			"desc" => __("In pixels, ex: 1px.", "Avada"),
			"id" => "content_box_margin_top",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Content Box Margin Bottom", "Avada"),
			"desc" => __("In pixels, ex: 1px.", "Avada"),
			"id" => "content_box_margin_bottom",
			"std" => "60px",
			"type" => "text");

		$of_options[] = array( "name" => __("Content Box Shortcode", "Avada"),
			"desc" => "",
			"id" => "cb_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Content Box Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Countdown Shortcode", "Avada"),
			"desc" => "",
			"id" => "countdown_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Countdown Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Countdown Timezone", "Avada"),
			"desc" => __("Choose which timezone should be used for the countdown calculation.", "Avada"),
			"id" => "countdown_timezone",
			"std" => 'site_time',
			"type" => "select",
			"options" => array( 'site_time' => 'Site Timezone', 'user_time' => 'User Timezone' ));

		$of_options[] = array( "name" => __("Countdown Show Weeks", "Avada"),
			"desc" => __("Select 'yes' to show weeks for longer countdowns.", "Avada"),
			"id" => "countdown_show_weeks",
			"std" => 'no',
			"type" => "select",
			"options" => array( 'no' => 'No', 'yes' => 'Yes' ));

		$of_options[] = array( "name" => __("Countdown Background Color", "Avada"),
			"desc" => __("Choose a background color for the countdown wrapping box.", "Avada"),
			"id" => "countdown_background_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Countdown Background Image", "Avada"),
			"desc" => __("Select an image or insert an image url to use for the background of the countdown wrapping box.", "Avada"),
			"id" => "countdown_background_image",
			"std" => "",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("Countdown Background Repeat", "Avada"),
			"desc" => __("Select how the background image repeats.", "Avada"),
			"id" => "countdown_background_repeat",
			"std" => "no-repeat",
			"type" => "select",
			"options" => array('repeat' => 'repeat', 'repeat-x' => 'repeat-x', 'repeat-y' => 'repeat-y', 'no-repeat' => 'no-repeat'));

		$of_options[] = array( "name" => __("Countdown Background Position", "Avada"),
			"desc" => __("Select the position from where background image starts.", "Avada"),
			"id" => "countdown_background_position",
			"std" => "center center",
			"type" => "select",
			"options" => $body_pos);

		$of_options[] = array( "name" => __("Countdown Counter Box Color", "Avada"),
			"desc" => __("Choose a background color for the counter boxes.", "Avada"),
			"id" => "countdown_counter_box_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Countdown Counter Text Color", "Avada"),
			"desc" => __("Choose a text color for the countdown timer.", "Avada"),
			"id" => "countdown_counter_text_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Countdown Heading Text Color", "Avada"),
			"desc" => __("Choose a heading text color for the countdown.", "Avada"),
			"id" => "countdown_heading_text_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Countdown Subheading Text Color", "Avada"),
			"desc" => __("Choose a subheading text color for the countdown.", "Avada"),
			"id" => "countdown_subheading_text_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Countdown Link Text Color", "Avada"),
			"desc" => __("Choose a text color for the countdown link.", "Avada"),
			"id" => "countdown_link_text_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Countdown Link Target", "Avada"),
			"desc" => __("_self = open in same window<br>_blank = open in new window.", "Avada"),
			"id" => "countdown_link_target",
			"std" => "_self",
			"type" => "select",
			"options" => array('_self' => '_self', '_blank' => '_blank'));

		$of_options[] = array( "name" => __("Countdown Shortcode", "Avada"),
			"desc" => "",
			"id" => "countdown_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Countdown Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Counter Boxes Shortcode", "Avada"),
			"desc" => "",
			"id" => "counterb_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Counter Boxes Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Counter Box Title Font Color", "Avada"),
			"desc" => __("Controls the color of the counter \"value\" and icon.", "Avada"),
			"id" => "counter_box_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Counter Box Title Font Size", "Avada"),
			"desc" => __("Controls the size of the counter \"value\" and icon. Enter the font size without 'px'. Default is 50.", "Avada"),
			"id" => "counter_box_title_size",
			"std" => "50",
			"type" => "text");

		$of_options[] = array( "name" => __("Counter Box Icon Size", "Avada"),
			"desc" => __("Controls the size of the icon. Enter the font size without 'px'. Default is 50.", "Avada"),
			"id" => "counter_box_icon_size",
			"std" => "50",
			"type" => "text");

		$of_options[] = array( "name" => __("Counter Box Body Font Color", "Avada"),
			"desc" => __("Controls the color of the counter body text.", "Avada"),
			"id" => "counter_box_body_color",
			"std" => '#747474',
			"type" => "color");

		$of_options[] = array( "name" => __("Counter Box Body Font Size", "Avada"),
			"desc" => __("Controls the size of the counter body text. Enter the font size without 'px'. Default is 13.", "Avada"),
			"id" => "counter_box_body_size",
			"std" => "13",
			"type" => "text");

		$of_options[] = array( "name" => __("Counter Box Border Color", "Avada"),
			"desc" => __("Controls the color of the border.", "Avada"),
			"id" => "counter_box_border_color",
			"std" => "#e0dede",
			"type" => "color");

		$of_options[] = array( "name" => __("Counter Box Icon on Top", "Avada"),
			"desc" => __("Controls the position of the icon.", "Avada"),
			"id" => "counter_box_icon_top",
			"std" => 'no',
			"type" => "select",
			"options" => array( 'no' => 'No', 'yes' => 'Yes' ));

		$of_options[] = array( "name" => __("Counter Boxes Shortcode", "Avada"),
			"desc" => "",
			"id" => "counterb_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Counter Boxes Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Counter Circle Shortcode", "Avada"),
			"desc" => "",
			"id" => "cc_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Counter Circles Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Counter Circle Filled Color", "Avada"),
			"desc" => __("Controls the color of the unfilled circle.", "Avada"),
			"id" => "counter_filled_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Counter Circle Unfilled Color", "Avada"),
			"desc" => __("Controls the color of the filled circle.", "Avada"),
			"id" => "counter_unfilled_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Counter Circle Shortcode", "Avada"),
			"desc" => "",
			"id" => "cc_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Counter Circle Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Dropcap Shortcode", "Avada"),
			"desc" => "",
			"id" => "dropcap_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Dropcap Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Dropcap Color", "Avada"),
			"desc" => __("Controls the color of the dropcap text, or the dropcap box if a box is used.", "Avada"),
			"id" => "dropcap_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Dropcap Shortcode", "Avada"),
			"desc" => "",
			"id" => "dropcap_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Dropcap Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Flip Boxes Shortcode", "Avada"),
			"desc" => "",
			"id" => "flipb_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Flip Boxes Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Flip Box Background Color Frontside", "Avada"),
			"desc" => __("Controls the color of frontside background color.", "Avada"),
			"id" => "flip_boxes_front_bg",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Flip Box Heading Color Frontside", "Avada"),
			"desc" => __("Controls the color of frontside heading color.", "Avada"),
			"id" => "flip_boxes_front_heading",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Flip Box Text Color Frontside", "Avada"),
			"desc" => __("Controls the color of frontside text color.", "Avada"),
			"id" => "flip_boxes_front_text",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Flip Box Background Color Backside", "Avada"),
			"desc" => __("Controls the color of backside background color.", "Avada"),
			"id" => "flip_boxes_back_bg",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Flip Box Heading Color Backside", "Avada"),
			"desc" => __("Controls the color of backside heading color.", "Avada"),
			"id" => "flip_boxes_back_heading",
			"std" => "#eeeded",
			"type" => "color");

		$of_options[] = array( "name" => __("Flip Box Text Color Backside", "Avada"),
			"desc" => __("Controls the color of backside text color.", "Avada"),
			"id" => "flip_boxes_back_text",
			"std" => "#ffffff",
			"type" => "color");


		$of_options[] = array( "name" => __("Flip Box Border Size", "Avada"),
			"desc" => __("Controls the border size of flip boxes.", "Avada"),
			"id" => "flip_boxes_border_size",
			"std" => "1px",
			"type" => "text");

		$of_options[] = array( "name" => __("Flip Box Border Color", "Avada"),
			"desc" => __("Controls the border color of flip boxes.", "Avada"),
			"id" => "flip_boxes_border_color",
			"std" => "transparent",
			"type" => "color");

		$of_options[] = array( "name" => __("Flip Box Border Radius", "Avada"),
			"desc" => __("Controls the border radius (roundness) of flip boxes.", "Avada"),
			"id" => "flip_boxes_border_radius",
			"std" => "4px",
			"type" => "text");

		$of_options[] = array( "name" => __("Flip Boxes Shortcode", "Avada"),
			"desc" => "",
			"id" => "flipb_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Flip Boxes Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Full Width Shortcode", "Avada"),
			"desc" => "",
			"id" => "fullwidth_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Full Width Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Full Width Background Color", "Avada"),
			"desc" => __("Controls the background color of the full width section.", "Avada"),
			"id" => "full_width_bg_color",
			"std" => "",
			"type" => "color");

	   $of_options[] = array( "name" => __("Full Width Border Size", "Avada"),
			"desc" => __("Controls the border size of the full width section.", "Avada"),
			"id" => "full_width_border_size",
			"std" => "0px",
			"type" => "text");

	   $of_options[] = array( "name" => __("Full Width Border Color", "Avada"),
			"desc" => __("Controls the border color of the full width section.", "Avada"),
			"id" => "full_width_border_color",
			"std" => "#eae9e9",
			"type" => "color");

		$of_options[] = array( "name" => __("Full Width Shortcode", "Avada"),
			"desc" => "",
			"id" => "fullwidth_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Full Width Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Icon Shortcode", "Avada"),
			"desc" => "",
			"id" => "icon_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Icon Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Icon Circle Background Color", "Avada"),
			"desc" => __("Controls the color of the circle when used with icons.", "Avada"),
			"id" => "icon_circle_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Icon Circle Border Color", "Avada"),
			"desc" => __("Controls the color of the circle border when used with icons.", "Avada"),
			"id" => "icon_border_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Icon Color", "Avada"),
			"desc" => __("Controls the color of the icons.", "Avada"),
			"id" => "icon_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Icon Shortcode", "Avada"),
			"desc" => "",
			"id" => "icon_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Icon Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Image Frame Shortcode", "Avada"),
			"desc" => "",
			"id" => "imgf_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Image Frame Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Image Frame Border Color", "Avada"),
			"desc" => __("Controls the border color of the image frame.", "Avada"),
			"id" => "imgframe_border_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Image Frame Border Size", "Avada"),
			"desc" => __("Controls the border size of the image. In pixels, ex: 4px.", "Avada"),
			"id" => "imageframe_border_size",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Image Frame Border Radius", "Avada"),
			"desc" => __("Controls the border radius of the image. In pixels, ex: 4px.", "Avada"),
			"id" => "imageframe_border_radius",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Image Frame Style Color", "Avada"),
			"desc" => __("Controls the style color of the image frame. Only works for glow and dropshadow style.", "Avada"),
			"id" => "imgframe_style_color",
			"std" => "#000000",
			"type" => "color");

		$of_options[] = array( "name" => __("Image Frame Shortcode", "Avada"),
			"desc" => "",
			"id" => "imgf_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Image Frame Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Modal Shortcode", "Avada"),
			"desc" => "",
			"id" => "modal_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Modal Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Modal Background Color", "Avada"),
			"desc" => __("Controls the background color of the modal popup box", "Avada"),
			"id" => "modal_bg_color",
			"std" => "#f6f6f6",
			"type" => "color");

	   $of_options[] = array( "name" => __("Modal Border Color", "Avada"),
			"desc" => __("Controls the border color of the modal popup box", "Avada"),
			"id" => "modal_border_color",
			"std" => "#ebebeb",
			"type" => "color");

		$of_options[] = array( "name" => __("Modal Shortcode", "Avada"),
			"desc" => "",
			"id" => "modal_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Modal Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Person Shortcode", "Avada"),
			"desc" => "",
			"id" => "person_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Person Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Person Background Color", "Avada"),
			"desc" => __("Controls the background color.", "Avada"),
			"id" => "person_background_color",
			"std" => "",
			"type" => "color");

			$of_options[] = array( "name" => __("Person Text Color", "Avada"),
			"desc" => __("Controls the text color.", "Avada"),
			"id" => "person_text_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Person Border Color", "Avada"),
			"desc" => __("Controls the border color of the of the image.", "Avada"),
			"id" => "person_border_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Person Border Size", "Avada"),
			"desc" => __("Controls the border size of the image. In pixels, ex: 4px.", "Avada"),
			"id" => "person_border_size",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Person Border Radius", "Avada"),
			"desc" => __("Controls the border radius of the image. In pixels, ex: 4px.", "Avada"),
			"id" => "person_border_radius",
			"std" => "0px",
			"type" => "text");

		$of_options[] = array( "name" => __("Person Style Color", "Avada"),
			"desc" => __("For all style types except border. Controls the style color. ", "Avada"),
			"id" => "person_style_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Person Content Alignment", "Avada"),
			"desc" => __("Choose the alignment of content.", "Avada"),
			"id" => "person_alignment",
			"std" => "Left",
			"type" => "select",
			"options" => array( 'Left' => 'Left', 'Center' => 'Center', 'Right' => 'Right' ));

		$of_options[] = array( "name" => __("Person Icons Position", "Avada"),
			"desc" => __("Choose the social icon position.", "Avada"),
			"id" => "person_icon_position",
			"std" => 'Top',
			"type" => "select",
			"options" => array( 'Top' => 'Top', 'Bottom' => 'Bottom' ));

		$of_options[] = array( "name" => __("Person Shortcode", "Avada"),
			"desc" => "",
			"id" => "person_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Person Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Popover Shortcode", "Avada"),
			"desc" => "",
			"id" => "popover_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Popover Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Popover Heading Background Color", "Avada"),
			"desc" => __("Controls the background color of popover heading area.", "Avada"),
			"id" => "popover_heading_bg_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Popover Content Background Color", "Avada"),
			"desc" => __("Controls the background color of popover content area.", "Avada"),
			"id" => "popover_content_bg_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Popover Border Color", "Avada"),
			"desc" => __("Controls the border color of popover box.", "Avada"),
			"id" => "popover_border_color",
			"std" => "#ebebeb",
			"type" => "color");

		$of_options[] = array( "name" => __("Popover Text Color", "Avada"),
			"desc" => __("Controls the text color inside the popover box. ", "Avada"),
			"id" => "popover_text_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Popover Position", "Avada"),
			"desc" => __("Controls the position of the popover in reference to the triggering text.", "Avada"),
			"id" => "popover_placement",
			"std" => "Top",
			"type" => "select",
			"options" => array( 'Top' => 'Top', 'Right' => 'Right', 'Bottom' => 'Bottom', 'Left' => 'Left' ));

		$of_options[] = array( "name" => __("Popover Shortcode", "Avada"),
			"desc" => "",
			"id" => "popover_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Popover Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Pricing Table Shortcode", "Avada"),
			"desc" => "",
			"id" => "pricingtable_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Pricing Table Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Pricing Box Style 1 Heading Color", "Avada"),
			"desc" => __("Controls the heading color of full boxed (style 1) pricing tables.", "Avada"),
			"id" => "full_boxed_pricing_box_heading_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Pricing Box Style 2 Heading Color", "Avada"),
			"desc" => __("Controls the heading color of separate (style 2) pricing boxes.", "Avada"),
			"id" => "sep_pricing_box_heading_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Pricing Box Color", "Avada"),
			"desc" => __("Controls the color portions of pricing boxes.", "Avada"),
			"id" => "pricing_box_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Pricing Box Background Color", "Avada"),
			"desc" => __("Controls the color of main background and title background.", "Avada"),
			"id" => "pricing_bg_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Pricing Box Border Color", "Avada"),
			"desc" => __("Controls the color of the outer border, pricing row and footer row backgrounds.", "Avada"),
			"id" => "pricing_border_color",
			"std" => "#f8f8f8",
			"type" => "color");

		$of_options[] = array( "name" => __("Pricing Box Divider Color", "Avada"),
			"desc" => __("Controls the color of the dividers in-between pricing rows.", "Avada"),
			"id" => "pricing_divider_color",
			"std" => "#ededed",
			"type" => "color");

		$of_options[] = array( "name" => __("Pricing Table Shortcode", "Avada"),
			"desc" => "",
			"id" => "pricingtable_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Pricing Table Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Progress Bar Shortcode", "Avada"),
			"desc" => "",
			"id" => "progressbar_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Progress Bar Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Progress Bar Filled Color", "Avada"),
			"desc" => __("Controls the color of the filled area in progress bars.", "Avada"),
			"id" => "progressbar_filled_color",
			"std" => "#a0ce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Progress Bar Filled Border Color", "Avada"),
			"desc" => __("Controls the border color of the filled area in progress bars.", "Avada"),
			"id" => "progressbar_filled_border_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Progress Bar Filled Border Size", "Avada"),
			"desc" => __("In pixels (px), ex: 1px.", "Avada"),
			"id" => "progressbar_filled_border_size",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Progress Bar Unfilled Color", "Avada"),
			"desc" => __("Controls the color of the unfilled area in progress bars.", "Avada"),
			"id" => "progressbar_unfilled_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Progress Bar Text Color", "Avada"),
			"desc" => __("Controls the color of the text in progress bars.", "Avada"),
			"id" => "progressbar_text_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Progress Bar Shortcode", "Avada"),
			"desc" => "",
			"id" => "progressbar_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Progress Bar Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Section Separator Shortcode", "Avada"),
			"desc" => "",
			"id" => "sectionseparator_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Section Separator Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Section Separator Border Size", "Avada"),
			"desc" => __("Controls the border size of the section separator.", "Avada"),
			"id" => "section_sep_border_size",
			"std" => "1px",
			"type" => "text");


		$of_options[] = array( "name" => __("Section Separator Background Color of Divider Candy", "Avada"),
			"desc" => __("Controls the background color of the divider candy.", "Avada"),
			"id" => "section_sep_bg",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Section Separator Border Color", "Avada"),
			"desc" => __("Controls the border color of the separator.", "Avada"),
			"id" => "section_sep_border_color",
			"std" => '#f6f6f6',
			"type" => "color");

	   $of_options[] = array( "name" => __("Section Separator Shortcode", "Avada"),
			"desc" => "",
			"id" => "sectionseparator_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Section Separator Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Separator Shortcode", "Avada"),
			"desc" => "",
			"id" => "separator_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Separator Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Separators Color", "Avada"),
			"desc" => __("Controls the color of all separators, divider lines and borders for meta, previous & next, filters, category page, boxes around number pagination, sidebar widgets, accordion divider lines, counter boxes and more.", "Avada"),
			"id" => "sep_color",
			"std" => "#e0dede",
			"type" => "color");

		$of_options[] = array( "name" => __("Separator Circle", "Avada"),
			"desc" => __("Check the box if you want to use circles around the icons on separators.", "Avada"),
			"id" => "separator_circle",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Border Size", "Avada"),
			"desc" => __("In pixels, ex: 1px.", "Avada"),
			"id" => "separator_border_size",
			"std" => "1px",
			"type" => "text");

		$of_options[] = array( "name" => __("Separator Shortcode", "Avada"),
			"desc" => "",
			"id" => "separator_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Separator Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Sharing Box Shortcode", "Avada"),
			"desc" => "",
			"id" => "sharingbox_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Sharing Box Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Sharing Box Background Color", "Avada"),
			"desc" => __("Controls the background color of the sharing box.", "Avada"),
			"id" => "sharing_box_bg_color",
			"std" => '#f6f6f6',
			"type" => "color");

		$of_options[] = array( "name" => __("Sharing Box Tagline Text Color", "Avada"),
			"desc" => __("Controls the text color of the tagline text.", "Avada"),
			"id" => "sharing_box_tagline_text_color",
			"std" => '#333333',
			"type" => "color");

	   $of_options[] = array( "name" => __("Sharing Box Shortcode", "Avada"),
			"desc" => "",
			"id" => "sharingbox_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Sharing Box Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Social Links Shortcode", "Avada"),
			"desc" => "",
			"id" => "sociallinks_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Social Links Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( 	"name" => __("Social Links Icons Font Size", "Avada"),
						"desc" 		=> __("In pixels, default is 16", "Avada"),
						"id" 		=> "social_links_font_size",
						"std" 		=> "16",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Social Links Custom Icons Color", "Avada"),
			"desc" => __("Select a custom social icon color. Use one hex value for all or separate by | symbol for multi-color. ex: #AA0000|#00AA00|#0000AA", "Avada"),
			"id" => "social_links_icon_color",
			"std" => "#bebdbd",
			"type" => "color");

		$of_options[] = array( "name" => __("Social Links Icons Boxed", "Avada"),
			"desc" => __("Controls whether each icon is displayed in a small box.", "Avada"),
			"id" => "social_links_boxed",
			"std" => "No",
			"type" => "select",
			"options" => array('No' => 'No', 'Yes' => 'Yes'));

		$of_options[] = array( "name" => __("Social Links Icons Custom Box Color", "Avada"),
			"desc" => __("Select a custom social icon box color. Use one hex value for all or separate by | symbol for multi-color. ex: #AA0000|#00AA00|#0000AA", "Avada"),
			"id" => "social_links_box_color",
			"std" => "#e8e8e8",
			"type" => "color");

		$of_options[] = array( "name" => __("Social Links Icons Boxed Radius", "Avada"),
			"desc" => __('Box radius for the social icons. In px or %, ex: 5px or 10% or "round".', "Avada"),
			"id" => "social_links_boxed_radius",
			"std" => "4px",
			"type" => "text");

		$of_options[] = array( 	"name" => __("Social Links Icons Boxed Padding", "Avada"),
						"desc" 		=> __("In pixels, default is 8", "Avada"),
						"id" 		=> "social_links_boxed_padding",
						"std" 		=> "8",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Social Links Icons Tooltip Position", "Avada"),
			"desc" => __("Controls the tooltip position of the social links icons.", "Avada"),
			"id" => "social_links_tooltip_placement",
			"std" => "Top",
			"type" => "select",
			"options" => array( 'Top' => 'Top', 'Right' => 'Right', 'Bottom' => 'Bottom', 'Left' => 'Left', 'None' => 'None' ));

	   $of_options[] = array( "name" => __("Social Links Shortcode", "Avada"),
			"desc" => "",
			"id" => "sociallinks_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Social Links Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Tabs Shortcode", "Avada"),
			"desc" => "",
			"id" => "tabs_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Tabs Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Tabs Background Color + Hover Color", "Avada"),
			"desc" => __("Controls the color of the active tab, content background color and tab hover.", "Avada"),
			"id" => "tabs_bg_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Tabs Inactive Color", "Avada"),
			"desc" => __("Controls the color of the inactive tabs.", "Avada"),
			"id" => "tabs_inactive_color",
			"std" => "#ebeaea",
			"type" => "color");

		$of_options[] = array( "name" => __("Tabs Border Color", "Avada"),
			"desc" => __("Controls the color of the outer tab border.", "Avada"),
			"id" => "tabs_border_color",
			"std" => "#ebeaea",
			"type" => "color");

	   $of_options[] = array( "name" => __("Tabs Shortcode", "Avada"),
			"desc" => "",
			"id" => "tabs_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Tabs Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Tagline Shortcode", "Avada"),
			"desc" => "",
			"id" => "tagline_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Tagline Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Tagline Box Background Color", "Avada"),
			"desc" => __("Controls the background color of the tagline box.", "Avada"),
			"id" => "tagline_bg",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Tagline Box Border Color", "Avada"),
			"desc" => __("Controls the border color of the tagline box.", "Avada"),
			"id" => "tagline_border_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Tagline Margin Top", "Avada"),
			"desc" => __("Controls the top margin of the tagline box. In pixels.", "Avada"),
			"id" => "tagline_margin_top",
			"std" => "",
			"type" => "text" );

		$of_options[] = array( "name" => __("Tagline Margin Bottom", "Avada"),
			"desc" => __("Controls the bottom margin of the tagline box. In pixels.", "Avada"),
			"id" => "tagline_margin_bottom",
			"std" => "84",
			"type" => "text" );

	   $of_options[] = array( "name" => __("Tagline Shortcode", "Avada"),
			"desc" => "",
			"id" => "tagline_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Tagline Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Testimonials Shortcode", "Avada"),
			"desc" => "",
			"id" => "testimonials_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Testimonials Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Testimonial Background Color", "Avada"),
			"desc" => __("Controls the background color of the testimonial.", "Avada"),
			"id" => "testimonial_bg_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Testimonial Text Color", "Avada"),
			"desc" => __("Controls the text color of the testimonial font.", "Avada"),
			"id" => "testimonial_text_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Testimonials Speed", "Avada"),
			"desc" => __("Select the slideshow speed, 1000 = 1 second.", "Avada"),
			"id" => "testimonials_speed",
			"std" => "4000",
			"type" => "text");

		$of_options[] = array( "name" => __("Random Order", "Avada"),
			"desc" => __("Check the box to display testimonials in random order.", "Avada"),
			"id" => "testimonials_random",
			"std" => 0,
			"type" => "checkbox");

	   $of_options[] = array( "name" => __("Testimonials Shortcode", "Avada"),
			"desc" => "",
			"id" => "testimonials_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Testimonials Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Title Shortcode", "Avada"),
			"desc" => "",
			"id" => "title_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Title Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Title Separator", "Avada"),
			"desc" => __("Choose the kind of the title separator you want to use.", "Avada"),
			"id" => "title_style_type",
			"std" => "double",
			"type" => "select",
			"options" => array(
				'single'		  	=> __('Single', 'Avada'),
				'single solid'		=> __('Single Solid', 'Avada'),
				'single dashed'		=> __('Single Dashed', 'Avada'),
				'single dotted'		=> __('Single Dotted', 'Avada'),
				'double'	 		=> __('Double', 'Avada'),
				'double solid'	 	=> __('Double Solid', 'Avada'),
				'double dashed'		=> __('Double Dashed', 'Avada'),
				'double dotted'		=> __('Double Dotted', 'Avada'),
				'underline'			=> __('Underline', 'Avada'),
				'underline solid'	=> __('Underline Solid', 'Avada'),
				'underline dashed'	=> __('Underline Dashed', 'Avada'),
				'underline dotted'	=> __('Underline Dotted', 'Avada'),
				'none'				=> __('None', 'Avada')
			));

		$of_options[] = array( "name" => __("Title Separator Color", "Avada"),
			"desc" => __("Controls the color of the title separators", "Avada"),
			"id" => "title_border_color",
			"std" => "#e0dede",
			"type" => "color");

		$of_options[] = array( "name" => __("Title Top Margin", "Avada"),
			"desc" => __("Spacing above the title. In px or em, e.g. 10px.", "Avada"),
			"id" => "title_top_margin",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Title Bottom Margin", "Avada"),
			"desc" => __("Spacing below the title. In px or em, e.g. 10px.", "Avada"),
			"id" => "title_bottom_margin",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Title Shortcode", "Avada"),
			"desc" => "",
			"id" => "title_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Title Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Toggles Shortcode", "Avada"),
			"desc" => "",
			"id" => "accordion_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Toggles Shortcode", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Toggle Divider Line", "Avada"),
			"desc" => __("Choose to display a divider line between each item.", "Avada"),
			"id" => "accordion_divider_line",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Toggles Inactive Box Color", "Avada"),
			"desc" => __("Controls the color of the inactive boxes behind the '+' icons.", "Avada"),
			"id" => "accordian_inactive_color",
			"std" => "#333333",
			"type" => "color");

	   $of_options[] = array( "name" => __("Toggles Shortcode", "Avada"),
			"desc" => "",
			"id" => "accordion_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("Toggles Shortcode", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("User Login Shortcodes", "Avada"),
			"desc" => "",
			"id" => "login_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("User Login Shortcodes", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("User Login Text Align", "Avada"),
			"desc" => __('Choose the alignment of all content parts. "Text Flow" follows the default text align of the site. "Center" will center all elements.', "Avada"),
			"id" => "user_login_text_align",
			"std" => "center",
			"type" => "select",
			"options" => array(
				'textflow' => 'Text Flow',
				'center' => 'Center',
			));

		$of_options[] = array( "name" => __("User Login Form Backgound Color", "Avada"),
			"desc" => __("Choose a background color for the form wrapping box.", "Avada"),
			"id" => "user_login_form_background_color",
			"std" => "#f6f6f6",
			"type" => "color");

	   $of_options[] = array( "name" => __("User Login Shortcodes", "Avada"),
			"desc" => "",
			"id" => "login_shortcode",
			"std" => "<h3 style='margin: 0;'>" . __("User Login Shortcodes", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");


		$of_options[] = array( "name" => __("Blog", "Avada"),
			"id" => "heading_blog",
			"type" => "heading");

		$of_options[] = array( "name" => __("General Blog Options", "Avada"),
			"desc" => "",
			"id" => "blog_single_post",
			"std" => "<h3 style='margin: 0;'>" . __("General Blog Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Blog Page Title", "Avada"),
			"desc" => __("This text will display in the page title bar of the assigned blog page. Note: This option only works if your front page is set to display your latest post in reading settings.", "Avada"),
			"id" => "blog_title",
			"std" => "Blog",
			"type" => "text");

		$of_options[] = array( "name" => __("Blog Page Subtitle", "Avada"),
			"desc" => __("This text will display as subheading in the page title bar of the assigned blog page. Note: This option only works if your front page is set to display your latest post in reading settings.", "Avada"),
			"id" => "blog_subtitle",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Page Title Bar", "Avada"),
			"desc" => __("Check the box to show the page title bar for the assigned blog page.", "Avada"),
			"id" => "blog_show_page_title_bar",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Blog Layout", "Avada"),
			"desc" => __("Select the layout for the assigned blog page in settings > reading.", "Avada"),
			"id" => "blog_layout",
			"std" => "Large",
			"type" => "select",
			"options" => array(
				'Large' => 'Large',
				'Medium' => 'Medium',
				'Large Alternate' => 'Large Alternate',
				'Medium Alternate' => 'Medium Alternate',
				'Grid' => 'Grid',
				'Timeline' => 'Timeline'
			));

		$of_options[] = array( "name" => __("Blog Archive/Category Layout", "Avada"),
			"desc" => __("Select the layout for the blog archive/category pages.", "Avada"),
			"id" => "blog_archive_layout",
			"std" => "Large",
			"type" => "select",
			"options" => array(
				'Large' => 'Large',
				'Medium' => 'Medium',
				'Large Alternate' => 'Large Alternate',
				'Medium Alternate' => 'Medium Alternate',
				'Grid' => 'Grid',
				'Timeline' => 'Timeline'
			));

		$of_options[] = array( "name" => __("Pagination Type", "Avada"),
			"desc" => __("Select the pagination type for the assigned blog page in settings > reading.", "Avada"),
			"id" => "blog_pagination_type",
			"std" => "Pagination",
			"type" => "select",
			"options" => array(
				'Pagination' => 'Pagination',
				'Infinite Scroll' => 'Infinite Scroll',
				'load_more_button' => 'Load More Button'
			));

		$of_options[] = array( "name" => __("Grid Layout # of Columns", "Avada"),
			"desc" => __("Select the amount of columns for the grid layout.", "Avada"),
			"id" => "blog_grid_columns",
			"std" => "3",
			"type" => "select",
			"options" => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			));

		$of_options[] = array( "name" => __("Grid Layout Column Spacing", "Avada"),
			"desc" => __("Insert the amount of spacing between grid items without 'px'. ex: 40", "Avada"),
			"id" => "blog_grid_column_spacing",
			"std" => "40",
			"type" => "text");

		$of_options[] = array( "name" => __("Excerpt or Full Blog Content", "Avada"),
			"desc" => __("Choose to display an excerpt or full content on blog pages.", "Avada"),
			"id" => "content_length",
			"std" => "Excerpt",
			"type" => "select",
			"options" => array('Excerpt' => 'Excerpt', 'Full Content' => 'Full Content'));

		$of_options[] = array( "name" => __("Excerpt Length", "Avada"),
			"desc" => __("Insert the number of words you want to show in the post excerpts.", "Avada"),
			"id" => "excerpt_length_blog",
			"std" => "55",
			"type" => "text");

		$of_options[] = array( "name" => __("Strip HTML from Excerpt", "Avada"),
			"desc" => __("Check the box if you want to strip HTML from the excerpt content only.", "Avada"),
			"id" => "strip_html_excerpt",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Featured Image / Video on Blog Archive Page", "Avada"),
			"desc" => __("Check the box to display featured images and videos on blog archive page.", "Avada"),
			"id" => "featured_images",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Blog Alternate Date Format - Month and Year", "Avada"),
			"desc" => __("<a href='http://codex.wordpress.org/Formatting_Date_and_Time'>Formatting Date and Time</a>", "Avada"),
			"id" => "alternate_date_format_month_year",
			"std" => "m, Y",
			"type" => "text");

		$of_options[] = array( "name" => __("Blog Alternate Date Format - Day", "Avada"),
			"desc" => __("<a href='http://codex.wordpress.org/Formatting_Date_and_Time'>Formatting Date and Time</a>", "Avada"),
			"id" => "alternate_date_format_day",
			"std" => "j",
			"type" => "text");

		$of_options[] = array( "name" => __("Blog Timeline Date Format - Timeline Labels", "Avada"),
			"desc" => __("<a href='http://codex.wordpress.org/Formatting_Date_and_Time'>Formatting Date</a>", "Avada"),
			"id" => "timeline_date_format",
			"std" => "F Y",
			"type" => "text");

		$of_options[] = array( "name" => __("Blog Single Post", "Avada"),
			"desc" => "",
			"id" => "blog_single_post",
			"std" => "<h3 style='margin: 0;'>" . __("Blog Single Post Page Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Use 100% Width Page", "Avada"),
			"desc" => __("Choose to set posts to 100% browser width.", "Avada"),
			"id" => "blog_width_100",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Featured Image / Video on Single Post Page", "Avada"),
			"desc" => __("Check the box to display featured images and videos on single post pages.", "Avada"),
			"id" => "featured_images_single",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Previous/Next Pagination", "Avada"),
			"desc" => __("Check the box to disable previous/next pagination.", "Avada"),
			"id" => "blog_pn_nav",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Post Title", "Avada"),
			"desc" => __("Check the box to display the post title that goes below the featured images.", "Avada"),
			"id" => "blog_post_title",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Author Info Box", "Avada"),
			"desc" => __("Check the box to display the author info box below posts.", "Avada"),
			"id" => "author_info",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Social Sharing Box", "Avada"),
			"desc" => __("Check the box to display the social sharing box.", "Avada"),
			"id" => "social_sharing_box",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Related Posts", "Avada"),
			"desc" => __("Check the box to display related posts.", "Avada"),
			"id" => "related_posts",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Comments", "Avada"),
			"desc" => __("Check the box to display comments.", "Avada"),
			"id" => "blog_comments",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Blog Meta", "Avada"),
			"desc" => "",
			"id" => "blog_meta",
			"std" => "<h3 style='margin: 0;'>" . __("Blog Meta Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Post Meta", "Avada"),
			"desc" => __("Check the box to display post meta on blog posts.", "Avada"),
			"id" => "post_meta",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Post Meta Author", "Avada"),
			"desc" => __("Check the box to hide the author name from post meta.", "Avada"),
			"id" => "post_meta_author",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Post Meta Date", "Avada"),
			"desc" => __("Check the box to hide the date from post meta.", "Avada"),
			"id" => "post_meta_date",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Post Meta Categories", "Avada"),
			"desc" => __("Check the box to hide the categories from post meta.", "Avada"),
			"id" => "post_meta_cats",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Post Meta Comments", "Avada"),
			"desc" => __("Check the box to hide the comments from post meta.", "Avada"),
			"id" => "post_meta_comments",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Post Meta Read More Link", "Avada"),
			"desc" => __("Check the box to hide the read more link from post meta.", "Avada"),
			"id" => "post_meta_read",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Post Meta Tags", "Avada"),
			"desc" => __("Check the box to hide the tags from post meta.", "Avada"),
			"id" => "post_meta_tags",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Date Format", "Avada"),
			"desc" => __("<a href='http://codex.wordpress.org/Formatting_Date_and_Time'>Formatting Date and Time</a>", "Avada"),
			"id" => "date_format",
			"std" => "F jS, Y",
			"type" => "text");

		$of_options[] = array( "name" => __("Portfolio", "Avada"),
			"id" => "heading_portfolio",
			"type" => "heading");

		$of_options[] = array( "name" => __("General Portfolio Options", "Avada"),
			"desc" => "",
			"id" => "blog_single_post",
			"std" => "<h3 style='margin: 0;'>" . __("General Portfolio Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Number of Portfolio Items Per Page", "Avada"),
			"desc" => __("Insert the number of posts to display per page.", "Avada"),
			"id" => "portfolio_items",
			"std" => "10",
			"type" => "text");

		$of_options[] = array( "name" => __("Portfolio Archive/Category Layout", "Avada"),
			"desc" => __("Select the layout for only the archive/category pages.", "Avada"),
			"id" => "portfolio_archive_layout",
			"std" => "Portfolio One Column",
			"type" => "select",
			"options" => array(
				'Portfolio One Column' => 'Portfolio One Column',
				'Portfolio Two Column' => 'Portfolio Two Column',
				'Portfolio Three Column' => 'Portfolio Three Column',
				'Portfolio Four Column' => 'Portfolio Four Column',
				'Portfolio Five Column' => 'Portfolio Five Column',
				'Portfolio Six Column' => 'Portfolio Six Column',
				'Portfolio One Column Text' => 'Portfolio One Column Text',
				'Portfolio Two Column Text' => 'Portfolio Two Column Text',
				'Portfolio Three Column Text' => 'Portfolio Three Column Text',
				'Portfolio Four Column Text' => 'Portfolio Four Column Text',
				'Portfolio Five Column Text' => 'Portfolio Five Column Text',
				'Portfolio Six Column Text' => 'Portfolio Six Column Text',
				'Portfolio Grid' => 'Portfolio Grid',
			));

		$of_options[] = array( "name" => __("Portfolio Archive/Category Column Spacing", "Avada"),
			"desc" => __("Insert the amount of spacing between portfolio items without 'px'.<br />ex: 12", "Avada"),
			"id" => "portfolio_column_spacing",
			"std" => "12",
			"type" => "text");

		$of_options[] = array( "name" => __("Excerpt or Full Portfolio Content", "Avada"),
			"desc" => __("Choose to show a text excerpt or full content.", "Avada"),
			"id" => "portfolio_content_length",
			"std" => "Excerpt",
			"type" => "select",
			"options" => array('Excerpt' => 'Excerpt', 'Full Content' => 'Full Content'));

		$of_options[] = array( "name" => __("Excerpt Length", "Avada"),
			"desc" => __("Insert the number of words you want to show in the post excerpts.", "Avada"),
			"id" => "excerpt_length_portfolio",
			"std" => "55",
			"type" => "text");

		$of_options[] = array( "name" => __("Strip HTML from Excerpt", "Avada"),
			"desc" => __("Check the box if you want to strip HTML from the excerpt content only.", "Avada"),
			"id" => "portfolio_strip_html_excerpt",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Pagination Type", "Avada"),
			"desc" => __("Select the pagination type for Portfolio layouts.", "Avada"),
			"id" => "grid_pagination_type",
			"std" => "Pagination",
			"type" => "select",
			"options" => array(
				'Pagination' => 'Pagination',
				'Infinite Scroll' => 'Infinite Scroll',
				'load_more_button' => 'Load More Button',
			));

		$of_options[] = array( "name" => __("Portfolio Text Layout", "Avada"),
			"desc" => __("Select if the portfolio text layouts are boxed or unboxed.", "Avada"),
			"id" => "portfolio_text_layout",
			"std" => "unboxed",
			"type" => "select",
			"options" => array(
				'boxed' => 'Boxed',
				'unboxed' => 'Unboxed',
			));

		$of_options[] = array( "name" => __("Portfolio Slug", "Avada"),
			"desc" => __("The slug name cannot be the same name as your portfolio page or the layout will break. This option changes the permalink when you use the permalink type as %postname%. <strong>Make sure to regenerate permalinks.</strong>", "Avada"),
			"id" => "portfolio_slug",
			"std" => "portfolio-items",
			"type" => "text");

		$of_options[] = array( "name" => __("Portfolio Featured Image Size ", "Avada"),
			"desc" => __("Choose if the featured images are fixed (cropped) or auto (full image ratio) for all portfolio column page templates. IMPORTANT: Fixed images work best with smaller site widths. Auto images work best with larger site widths.", "Avada"),
			"id" => "portfolio_featured_image_size",
			"std" => "cropped",
			"type" => "select",
			"options" => array(
				'cropped' => 'Fixed',
				'full' => 'Auto',
			));

		$of_options[] = array( "name" => __("Portfolio Single Post Page Options", "Avada"),
			"desc" => "",
			"id" => "blog_single_post",
			"std" => "<h3 style='margin: 0;'>" . __("Portfolio Single Post Page Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Disable Previous/Next Pagination", "Avada"),
			"desc" => __("Check the box to disable previous/next pagination.", "Avada"),
			"id" => "portfolio_pn_nav",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Featured Image / Video on Single Post Page", "Avada"),
			"desc" => __("Check the box to display featured images and videos on single post pages.", "Avada"),
			"id" => "portfolio_featured_images",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable First Featured Image", "Avada"),
			"desc" => __("Disable the 1st featured image on single post pages.", "Avada"),
			"id" => "portfolio_disable_first_featured_image",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Width (Content Columns for Featured Image)", "Avada"),
			"desc" => __("Choose if the featured image is full or half width.", "Avada"),
			"id" => "portfolio_featured_image_width",
			"std" => "No",
			"type" => "select",
			"options" => array('full' => 'Full Width', 'half' => 'Half Width'));


		$of_options[] = array( "name" => __("Use 100% Width Page", "Avada"),
			"desc" => __("Choose to set posts to 100% browser width.", "Avada"),
			"id" => "portfolio_width_100",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Project Description Title", "Avada"),
			"desc" => __("Choose to show or hide the project description title.", "Avada"),
			"id" => "portfolio_project_desc_title",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Project Details", "Avada"),
			"desc" => __("Choose to show or hide the project details text.", "Avada"),
			"id" => "portfolio_project_details",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Open Post Links In New Window", "Avada"),
			"desc" => __("Choose to open the single post page, project url and copyright url links in a new window..", "Avada"),
			"id" => "portfolio_link_icon_target",
			"std" => 0,
			"type" => "checkbox");


		$of_options[] = array( "name" => __("Show Comments", "Avada"),
			"desc" => __("Check the box to enable comments on portfolio items.", "Avada"),
			"id" => "portfolio_comments",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Author", "Avada"),
			"desc" => __("Check the box to enable Author on portfolio items.", "Avada"),
			"id" => "portfolio_author",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Social Sharing Box", "Avada"),
			"desc" => __("Check the box to display the social sharing box.", "Avada"),
			"id" => "portfolio_social_sharing_box",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Related Posts", "Avada"),
			"desc" => __("Check the box to display related posts.", "Avada"),
			"id" => "portfolio_related_posts",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Social Sharing Box", "Avada"),
			"id" => "heading_social_sharing_box",
			"type" => "heading");

		$of_options[] = array( "name" => __("Social Share Box Icon Options", "Avada"),
			"desc" => "",
			"id" => "social_share_box_icon_options_title",
			"std" => "<h3 style='margin: 0;'>" . __("Social Share Box Icon Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Social Sharing Box Tagline", "Avada"),
			"desc" => __("Insert a tagline for the social sharing boxes.", "Avada"),
			"id" => "sharing_social_tagline",
			"std" => "Share This Story, Choose Your Platform!",
			"type" => "text");

		$of_options[] = array( "name" => __("Social Share Box Background Color", "Avada"),
			"desc" => __("Controls the background color of the social share box.", "Avada"),
			"id" => "social_bg_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( 	"name" => __("Social Sharing Box Icons Font Size", "Avada"),
						"desc" 		=> __("In pixels, default is 16", "Avada"),
						"id" 		=> "sharing_social_links_font_size",
						"std" 		=> "16",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Social Sharing Box Custom Icons Color", "Avada"),
			"desc" => __("Select a custom social icon color. Use one hex value for all or separate by | symbol for multi-color. ex: #AA0000|#00AA00|#0000AA", "Avada"),
			"id" => "sharing_social_links_icon_color",
			"std" => "#bebdbd",
			"type" => "color");

		$of_options[] = array( "name" => __("Social Sharing Box Icons Boxed", "Avada"),
			"desc" => __("Controls whether each icon is displayed in a small box.", "Avada"),
			"id" => "sharing_social_links_boxed",
			"std" => "No",
			"type" => "select",
			"options" => array('No' => 'No', 'Yes' => 'Yes'));

		$of_options[] = array( "name" => __("Social Sharing Box Icons Custom Box Color", "Avada"),
			"desc" => __("Select a custom social icon box color. Use one hex value for all or separate by | symbol for multi-color. ex: #AA0000|#00AA00|#0000AA", "Avada"),
			"id" => "sharing_social_links_box_color",
			"std" => "#e8e8e8",
			"type" => "color");

		$of_options[] = array( "name" => __("Social Sharing Box Icons Boxed Radius", "Avada"),
			"desc" => __("Box radius for the social icons. In pixels, ex: 4px.", "Avada"),
			"id" => "sharing_social_links_boxed_radius",
			"std" => "4px",
			"type" => "text");

		$of_options[] = array( 	"name" => __("Social Sharing Box Icons Boxed Padding", "Avada"),
						"desc" 		=> __("In pixels, default is 8", "Avada"),
						"id" 		=> "sharing_social_links_boxed_padding",
						"std" 		=> "8",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Social Sharing Box Icons Tooltip Position", "Avada"),
			"desc" => __("Controls the tooltip position of the social icons in the sharing box.", "Avada"),
			"id" => "sharing_social_links_tooltip_placement",
			"std" => "Top",
			"type" => "select",
			"options" => array( 'Top' => 'Top', 'Right' => 'Right', 'Bottom' => 'Bottom', 'Left' => 'Left', 'None' => 'None' ));

		$of_options[] = array( "name" => __("Social Share Box Links", "Avada"),
			"desc" => "",
			"id" => "social_share_box_links_title",
			"std" => "<h3 style='margin: 0;'>" . __("Social Share Box Links", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Facebook", "Avada"),
			"desc" => __("Check the box to show the facebook sharing icon in blog posts.", "Avada"),
			"id" => "sharing_facebook",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Twitter", "Avada"),
			"desc" => __("Check the box to show the twitter sharing icon in blog posts.", "Avada"),
			"id" => "sharing_twitter",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Reddit", "Avada"),
			"desc" => __("Check the box to show the reddit sharing icon in blog posts.", "Avada"),
			"id" => "sharing_reddit",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("LinkedIn", "Avada"),
			"desc" => __("Check the box to show the linkedin sharing icon in blog posts.", "Avada"),
			"id" => "sharing_linkedin",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Google Plus", "Avada"),
			"desc" => __("Check the box to show the g+ sharing icon in blog posts.", "Avada"),
			"id" => "sharing_google",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Tumblr", "Avada"),
			"desc" => __("Check the box to show the tumblr sharing icon in blog posts.", "Avada"),
			"id" => "sharing_tumblr",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Pinterest", "Avada"),
			"desc" => __("Check the box to show the pinterest sharing icon in blog posts.", "Avada"),
			"id" => "sharing_pinterest",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("VK", "Avada"),
			"desc" => __("Check the box to show the vk sharing icon in blog posts.", "Avada"),
			"id" => "sharing_vk",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Email", "Avada"),
			"desc" => __("Check the box to show the email sharing icon in blog posts.", "Avada"),
			"id" => "sharing_email",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Social Media", "Avada"),
			"id" => "heading_social_media",
			"type" => "heading");

		$social_links[] = array( "name" => __("Facebook", "Avada"),
			"desc" => __("Insert your custom link to show the Facebook icon. Leave blank to hide icon.", "Avada"),
			"id" => "facebook_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Flickr", "Avada"),
			"desc" => __("Insert your custom link to show the Flickr icon. Leave blank to hide icon.", "Avada"),
			"id" => "flickr_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("RSS", "Avada"),
			"desc" => __("Insert your custom link to show the RSS icon. Leave blank to hide icon.", "Avada"),
			"id" => "rss_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Twitter", "Avada"),
			"desc" => __("Insert your custom link to show the Twitter icon. Leave blank to hide icon.", "Avada"),
			"id" => "twitter_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Vimeo", "Avada"),
			"desc" => __("Insert your custom link to show the Vimeo icon. Leave blank to hide icon.", "Avada"),
			"id" => "vimeo_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Youtube", "Avada"),
			"desc" => __("Insert your custom link to show the Youtube icon. Leave blank to hide icon.", "Avada"),
			"id" => "youtube_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Instagram", "Avada"),
			"desc" => __("Insert your custom link to show the Instagram icon. Leave blank to hide icon.", "Avada"),
			"id" => "instagram_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Pinterest", "Avada"),
			"desc" => __("Insert your custom link to show the Pinterest icon. Leave blank to hide icon.", "Avada"),
			"id" => "pinterest_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Tumblr", "Avada"),
			"desc" => __("Insert your custom link to show the Tumblr icon. Leave blank to hide icon.", "Avada"),
			"id" => "tumblr_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Google+", "Avada"),
			"desc" => __("Insert your custom link to show the Google+ icon. Leave blank to hide icon.", "Avada"),
			"id" => "google_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Dribbble", "Avada"),
			"desc" => __("Insert your custom link to show the Dribbble icon. Leave blank to hide icon.", "Avada"),
			"id" => "dribbble_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Digg", "Avada"),
			"desc" => __("Insert your custom link to show the Digg icon. Leave blank to hide icon.", "Avada"),
			"id" => "digg_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("LinkedIn", "Avada"),
			"desc" => __("Insert your custom link to show the LinkedIn icon. Leave blank to hide icon.", "Avada"),
			"id" => "linkedin_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Blogger", "Avada"),
			"desc" => __("Insert your custom link to show the Blogger icon. Leave blank to hide icon.", "Avada"),
			"id" => "blogger_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Skype", "Avada"),
			"desc" => __("Insert your custom link to show the Skype icon. Leave blank to hide icon.", "Avada"),
			"id" => "skype_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Forrst", "Avada"),
			"desc" => __("Insert your custom link to show the Forrst icon. Leave blank to hide icon.", "Avada"),
			"id" => "forrst_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Myspace", "Avada"),
			"desc" => __("Insert your custom link to show the Myspace icon. Leave blank to hide icon.", "Avada"),
			"id" => "myspace_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Deviantart", "Avada"),
			"desc" => __("Insert your custom link to show the Deviantart icon. Leave blank to hide icon.", "Avada"),
			"id" => "deviantart_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Yahoo", "Avada"),
			"desc" => __("Insert your custom link to show the Yahoo icon. Leave blank to hide icon.", "Avada"),
			"id" => "yahoo_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Reddit", "Avada"),
			"desc" => __("Insert your custom link to show the Reddit icon. Leave blank to hide icon.", "Avada"),
			"id" => "reddit_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Paypal", "Avada"),
			"desc" => __("Insert your custom link to show the Paypal icon. Leave blank to hide icon.", "Avada"),
			"id" => "paypal_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Dropbox", "Avada"),
			"desc" => __("Insert your custom link to show the Dropbox icon. Leave blank to hide icon.", "Avada"),
			"id" => "dropbox_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Soundcloud", "Avada"),
			"desc" => __("Insert your custom link to show the Soundcloud icon. Leave blank to hide icon.", "Avada"),
			"id" => "soundcloud_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("VK", "Avada"),
			"desc" => __("Insert your custom link to show the VK icon. Leave blank to hide icon.", "Avada"),
			"id" => "vk_link",
			"std" => "",
			"type" => "text");

		$social_links[] = array( "name" => __("Email Address", "Avada"),
			"desc" => __("Insert your custom link to show the mail icon. Leave blank to hide icon.", "Avada"),
			"id" => "email_link",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => "",
			"desc" => "",
			"id" => "social_sorter",
			"std" => "",
			"type" => "fusion_sorter",
			"fields" => $social_links,
		);

		$of_options[] = array( "name" => __("Custom Social Icon", "Avada"),
			"desc" => "",
			"id" => "custom_color_scheme_element",
			"std" => "<h3 style='margin: 0;'>" . __("Custom Social Icon", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Custom Icon Name", "Avada"),
			"desc" => __("This is the icon name that shows in the hover tooltip.", "Avada"),
			"id" => "custom_icon_name",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Custom Icon Image", "Avada"),
			"desc" => __("Select an image file for your custom icon.", "Avada"),
			"id" => "custom_icon_image",
			"std" => "",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("Custom Icon Image Retina", "Avada"),
			"desc" => __("Select an image file for the retina version of the icon. It should be 2x the size of main icon.", "Avada"),
			"id" => "custom_icon_image_retina",
			"std" => "",
			"mod" => "",
			"type" => "media");

		$of_options[] = array( "name" => __("Standard Icon Width for Retina Icon", "Avada"),
			"desc" => __("If retina icon is added, enter the standard icon (1x) version width, do not enter the retina icon width.", "Avada"),
			"id" => "retina_icon_width",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Standard Icon Height for Retina Icon", "Avada"),
			"desc" => __("If retina icon is added, enter the standard icon (1x) version height, do not enter the retina icon height.", "Avada"),
			"id" => "retina_icon_height",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Custom Icon Link", "Avada"),
			"desc" => __("Insert a link for your custom icon.", "Avada"),
			"id" => "custom_icon_link",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Slideshows", "Avada"),
			"id" => "heading_slideshows",
			"type" => "heading");

		$of_options[] = array( "name" => __("Posts Slideshow Images", "Avada"),
			"desc" => __("This option controls the number of featured image boxes for blog/portfolio slideshows.", "Avada"),
			"id" => "posts_slideshow_number",
			"std" => "5",
			"type" => "text");

		$of_options[] = array( "name" => __("Autoplay", "Avada"),
			"desc" => __("Check the box to autoplay the slideshow.", "Avada"),
			"id" => "slideshow_autoplay",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Enable Smooth Height", "Avada"),
			"desc" => __("Check the box to enable smooth height on slideshows when using images with different heights. Please note, smooth height is disabled on blog grid layout.", "Avada"),
			"id" => "slideshow_smooth_height",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Slideshow Speed", "Avada"),
			"desc" => __("Controls the speed of slideshows for the [slider] shortcode and sliders within posts. ex: 1000 = 1 second.", "Avada"),
			"id" => "slideshow_speed",
			"std" => "7000",
			"type" => "text");

		$of_options[] = array( "name" => __("Pagination Circles Below Video Slides", "Avada"),
			"desc" => __("Check the box if you want to show pagination circles below a video slide for the slider shortcode. Leave it unchecked to hide them on video slides.", "Avada"),
			"id" => "pagination_video_slide",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Navigation Box Width", "Avada"),
			"desc" => __("Enter a pixel value for width, ex: 30px", "Avada"),
			"id" => "slider_nav_box_width",
			"std" => "30px",
			"type" => "text");

		$of_options[] = array( "name" => __("Navigation Box Height", "Avada"),
		"desc" => __("Enter a pixel value for height, ex: 30px", "Avada"),
		"id" => "slider_nav_box_height",
		"std" => "30px",
		"type" => "text");

		$of_options[] = array( "name" => __("Navigation Arrow Size", "Avada"),
		"desc" => __("Enter a pixel value for the arrow size, ex: 14px", "Avada"),
		"id" => "slider_arrow_size",
		"std" => "14px",
		"type" => "text");

		$of_options[] = array( "name" => __("Elastic Slider", "Avada"),
			"id" => "heading_elastic_slider",
			"type" => "heading");

		$of_options[] = array( "name" => __("Slider Width", "Avada"),
			"desc" => __("In pixels or percentage, ex: 100% or 100.", "Avada"),
			"id" => "tfes_slider_width",
			"std" => "100%",
			"type" => "text");

		$of_options[] = array( "name" => __("Slider Height", "Avada"),
			"desc" => __("In pixels, ex: 100px.", "Avada"),
			"id" => "tfes_slider_height",
			"std" => "400px",
			"type" => "text");

		$of_options[] = array( "name" => __("Animation", "Avada"),
			"desc" => __("Slides animate from sides or center.", "Avada"),
			"id" => "tfes_animation",
			"std" => "sides",
			"options" => array('sides' => 'sides', 'center' => 'center'),
			"type" => "select");

		$of_options[] = array( "name" => __("Autoplay", "Avada"),
			"desc" => __("Check the box to autoplay the slides.", "Avada"),
			"id" => "tfes_autoplay",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Slideshow Interval", "Avada"),
			"desc" => __("Select the slideshow speed, 1000 = 1 second.", "Avada"),
			"id" => "tfes_interval",
			"std" => "3000",
			"type" => "text");

		$of_options[] = array( "name" => __("Sliding Speed", "Avada"),
			"desc" => __("Select the animation speed, 1000 = 1 second.", "Avada"),
			"id" => "tfes_speed",
			"std" => "800",
			"type" => "text");

		$of_options[] = array( "name" => __("Thumbnail Width", "Avada"),
			"desc" => __("Enter the width for thumbnail without 'px' ex: 100.", "Avada"),
			"id" => "tfes_width",
			"std" => "150",
			"type" => "text");

		$of_options[] = array( 	"name" => __("Title Font Size", "Avada"),
						"desc" 		=> __("In pixels, default is 42", "Avada"),
						"id" 		=> "es_title_font_size",
						"std" 		=> "42",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( 	"name" => __("Caption Font Size", "Avada"),
						"desc" 		=> __("In pixels, default is 20", "Avada"),
						"id" 		=> "es_caption_font_size",
						"std" 		=> "20",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Title Color", "Avada"),
			"desc" => __("Controls the text color of the title font.", "Avada"),
			"id" => "es_title_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Caption Color", "Avada"),
			"desc" => __("Controls the text color of the caption font.", "Avada"),
			"id" => "es_caption_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Lightbox", "Avada"),
			"id" => "heading_lightbox",
			"type" => "heading");

		$of_options[] = array( "name" => __("Lightbox", "Avada"),
			"desc" => "",
			"id" => "lightbox",
			"std" => "<h3 style='margin: 0;'>" . __("Lightbox Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Disable Lightbox", "Avada"),
			"desc" => __("Check to disable Lightbox.", "Avada"),
			"id" => "status_lightbox",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Lightbox On Single Post Pages Only", "Avada"),
			"desc" => __("Check the box to disable Lightbox only on single posts and portfolio pages.", "Avada"),
			"id" => "status_lightbox_single",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Lightbox Behavior", "Avada"),
			"desc" => __("Select what the lightbox will display for portfolio and blog posts.", "Avada"),
			"id" => "lightbox_behavior",
			"std" => "all",
			"type" => "select",
			"options" => array('all' => 'First featured image of every post', 'individual' => 'Only featured images of individual post'));


		$of_options[] = array( "name" => __("Lightbox Skin", "Avada"),
			"desc" => __("Choose a skin for the lightbox.", "Avada"),
			"id" => "lightbox_skin",
			"std" => "metro-white",
			"type" => "select",
			"options" => array('light' => 'Light', 'dark' => 'Dark', 'mac' => 'Mac', 'metro-black' => 'Metro Black', 'metro-white' => 'Metro White', 'parade' => 'Parade', 'smooth' => 'Smooth'));

		$of_options[] = array( "name" => __("Thumbnails Position", "Avada"),
			"desc" => __("Choose position of thumbnails.", "Avada"),
			"id" => "lightbox_path",
			"std" => "vertical",
			"type" => "select",
			"options" => array('vertical' => 'Right', 'horizontal' => 'Bottom'));

		$of_options[] = array( "name" => __("Animation Speed", "Avada"),
			"desc" => __("Set the speed of the animation.", "Avada"),
			"id" => "lightbox_animation_speed",
			"std" => "Normal",
			"type" => "select",
			"options" => array('Fast' => 'Fast', 'Slow' => 'Slow', 'Normal' => 'Normal'));

		$of_options[] = array( "name" => __("Show Arrows", "Avada"),
			"desc" => __("Check the box to show arrows.", "Avada"),
			"id" => "lightbox_arrows",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Gallery Start/Stop Button", "Avada"),
			"desc" => __("Check the box to show the gallery start and stop button.", "Avada"),
			"id" => "lightbox_gallery",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Autoplay the Lightbox Gallery", "Avada"),
			"desc" => __("Check the box to autoplay the lightbox gallery.", "Avada"),
			"id" => "lightbox_autoplay",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Slideshow Speed", "Avada"),
			"desc" => __("If autoplay is enabled, set the slideshow speed, 1000 = 1 second. Speed needs to be 1000ms at least.", "Avada"),
			"id" => "lightbox_slideshow_speed",
			"std" => "5000",
			"type" => "text");

		$of_options[] = array( "name" => __("Background Opacity", "Avada"),
			"desc" => __("Set the opacity of background, <br />0.1 (lowest) to 1 (highest).", "Avada"),
			"id" => "lightbox_opacity",
			"std" => "0.9",
			"type" => "text");

		$of_options[] = array( "name" => __("Show Title", "Avada"),
			"desc" => __("Check the box to show the image title in the lightbox.", "Avada"),
			"id" => "lightbox_title",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Caption", "Avada"),
			"desc" => __("Check the box to show the image caption in the lightbox.", "Avada"),
			"id" => "lightbox_desc",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Social Sharing", "Avada"),
			"desc" => __("Check the box to show social sharing buttons on lightbox.", "Avada"),
			"id" => "lightbox_social",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Deeplinking", "Avada"),
			"desc" => __("Check the box to deeplink images in the lightbox.", "Avada"),
			"id" => "lightbox_deeplinking",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Post Images in Lightbox", "Avada"),
			"desc" => __("Check the box to show post images that are inside the post content area in the lightbox.", "Avada"),
			"id" => "lightbox_post_images",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Slideshow Video Width", "Avada"),
			"desc" => __("Set the width that will be used for videos inside the lightbox. In pixel, ex. 800px", "Avada"),
			"id" => "lightbox_video_width",
			"std" => "1280px",
			"type" => "text");

		$of_options[] = array( "name" => __("Slideshow Video Height", "Avada"),
			"desc" => __("Set the height that will be used for videos inside the lightbox. In pixel, ex. 600px", "Avada"),
			"id" => "lightbox_video_height",
			"std" => "720px",
			"type" => "text");

		$of_options[] = array( "name" => __("Contact", "Avada"),
			"id" => "heading_contact",
			"type" => "heading");

		$of_options[] = array( "name" => __("Email Address", "Avada"),
			"desc" => __("Enter the email adress the form will be sent to.", "Avada"),
			"id" => "email_address",
			"std" => "",
			"type" => "text");
			
		$of_options[] = array( "name" => __("Contact Form Commment Area Position", "Avada"),
			"desc" => __("Set the position of the contact form comment area with respect to the other input fields.", "Avada"),
			"id" => "contact_comment_position",
			"std" => "below",
			"type" => "select",
			"options" => array('above' => 'Above', 'below' => 'Below'));			
			
			

		$of_options[] = array( "name" => __("ReCaptcha", "Avada"),
			"desc" => "",
			"id" => "recaptcha",
			"std" => "<h3 style='margin: 0;'>" . __("ReCaptcha Spam Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("ReCaptcha Site Key", "Avada"),
			"desc" => __("Follow the steps in <a href='http://theme-fusion.com/avada-doc/pages/setting-up-contact-page/'> our docs</a> to get key.", "Avada"),
			"id" => "recaptcha_public",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("ReCaptcha Secret Key", "Avada"),
			"desc" => __("Follow the steps in <a href='http://theme-fusion.com/avada-doc/pages/setting-up-contact-page/'> our docs</a> to get key.", "Avada"),
			"id" => "recaptcha_private",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("ReCaptcha Color Scheme", "Avada"),
			"desc" => __("Select the recaptcha color scheme.", "Avada"),
			"id" => "recaptcha_color_scheme",
			"std" => "Clean",
			"type" => "select",
			"options" => array('light' => 'Light', 'dark' => 'Dark'));

		$of_options[] = array( "name" => __("ReCaptcha", "Avada"),
			"desc" => "",
			"id" => "recaptcha",
			"std" => "<h3 style='margin: 0;'>" . __("ReCaptcha Spam Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Google Map", "Avada"),
			"desc" => "",
			"id" => "google_map",
			"std" => "<h3 style='margin: 0;'>" . __("Google Map Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Google Map Type", "Avada"),
			"desc" => __("Select the type of google map to show on the contact page.", "Avada"),
			"id" => "gmap_type",
			"std" => "roadmap",
			"options" => array('roadmap' => 'roadmap', 'satellite' => 'satellite', 'hybrid' => 'hybrid', 'terrain' => 'terrain'),
			"type" => "select");

		$of_options[] = array( "name" => __("Google Map Width", "Avada"),
			"desc" => __("In pixels or percentage, ex: 100% or 100px.", "Avada"),
			"id" => "gmap_width",
			"std" => "100%",
			"type" => "text");

		$of_options[] = array( "name" => __("Google Map Height", "Avada"),
			"desc" => __("In pixels, ex: 100px.", "Avada"),
			"id" => "gmap_height",
			"std" => "415px",
			"type" => "text");

		$of_options[] = array( "name" => __("Google Map Top Margin", "Avada"),
			"desc" => __("This will only be applied to maps that are not 100% width. It controls the distance to menu/page title. In pixels, ex: 100px.", "Avada"),
			"id" => "gmap_topmargin",
			"std" => "55px",
			"type" => "text");

		$of_options[] = array( "name" => __("Google Map Address", "Avada"),
			"desc" => __("Add your address to the location you wish to show on the map. Single address ex: 775 New York Ave, Brooklyn, Kings, New York 11203. If the location is off, please try to use long/lat coordinates with latlng=. ex: latlng=12.381068,-1.492711.<br />For multiple addresses, separate addresses by using the | symbol. ex: Address 1|Address 2|Address 3.", "Avada"),
			"id" => "gmap_address",
			"std" => "775 New York Ave, Brooklyn, Kings, New York 11203",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Map Zoom Level", "Avada"),
			"desc" => __("Higher number will be more zoomed in.", "Avada"),
			"id" => "map_zoom_level",
			"std" => "8",
			"type" => "text");

		$of_options[] = array( "name" => __("Hide Address Pin", "Avada"),
			"desc" => __("Check the box to hide the address pin.", "Avada"),
			"id" => "map_pin",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Address Pin Animation", "Avada"),
			"desc" => __("Check the box to enable address pin animation.", "Avada"),
			"id" => "gmap_pin_animation",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Map Popup On Click", "Avada"),
			"desc" => __("Check the box to keep the popup graphic with address info hidden when the google map loads. It will only show when the pin on the map is clicked.", "Avada"),
			"id" => "map_popup",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Map Scrollwheel", "Avada"),
			"desc" => __("Check the box to disable scrollwheel on google maps.", "Avada"),
			"id" => "map_scrollwheel",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Map Scale", "Avada"),
			"desc" => __("Check the box to disable scale on google maps.", "Avada"),
			"id" => "map_scale",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Map Zoom & Pan Control Icons", "Avada"),
			"desc" => __("Check the box to disable zoom control icon and pan control icon on google maps.", "Avada"),
			"id" => "map_zoomcontrol",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Google Map", "Avada"),
			"desc" => "",
			"id" => "google_map",
			"std" => "<h3 style='margin: 0;'>" . __("Google Map Options", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Google Map Design Styling", "Avada"),
			"desc" => "",
			"id" => "google_map",
			"std" => "<h3 style='margin: 0;'>" . __("Google Map Design Styling", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Select the Map Styling", "Avada"),
			"desc" => __("Choose default styling for classic google map styles. Choose theme styling for our custom style. Choose custom styling to make your own with the advanced options below.", "Avada"),
			"id" => "map_styling",
			"std" => "default",
			"options" => array('default' => 'Default Styling', 'theme' => 'Theme Styling', 'custom' => 'Custom Styling'),
			"type" => "select");

		$of_options[] = array( "name" => __("Map Overlay Color", "Avada"),
			"desc" => __("Custom styling setting only. Pick an overlaying color for the map. Works best with \"roadmap\" type.", "Avada"),
			"id" => "map_overlay_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Info Box Styling", "Avada"),
			"desc" => __("Custom styling setting only. Choose between default or custom info box.", "Avada"),
			"id" => "map_infobox_styling",
			"std" => "default",
			"options" => array('default' => 'Default Infobox', 'custom' => 'Custom Infobox'),
			"type" => "select");

		$of_options[] = array( "name" => __("Info Box Content", "Avada"),
			"desc" => __("Custom styling setting only. Type in custom info box content to replace address string. For multiple addresses, separate info box contents by using the | symbol. ex: InfoBox 1|InfoBox 2|InfoBox 3", "Avada"),
			"id" => "map_infobox_content",
			"std" => "",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Info Box Background Color", "Avada"),
			"desc" => __("Custom styling setting only. Pick a color for the info box background.", "Avada"),
			"id" => "map_infobox_bg_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Info Box Text Color", "Avada"),
			"desc" => __("Custom styling setting only. Pick a color for the info box text.", "Avada"),
			"id" => "map_infobox_text_color",
			"std" => "",
			"type" => "color");

		$of_options[] = array( "name" => __("Custom Marker Icon", "Avada"),
			"desc" => __("Custom styling setting only. Use full image urls for custom marker icons or input \"theme\" for our custom marker. For multiple addresses, separate icons by using the | symbol or use one for all. ex: Icon 1|Icon 2|Icon 3", "Avada"),
			"id" => "map_custom_marker_icon",
			"std" => "",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Google Map Design Styling", "Avada"),
			"desc" => "",
			"id" => "google_map",
			"std" => "<h3 style='margin: 0;'>" . __("Google Map Design Styling", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Search Page", "Avada"),
			"id" => "heading_search_page",
			"type" => "heading");

		$of_options[] = array( "name" => __("Search", "Avada"),
			"desc" => "",
			"id" => "search",
			"std" => "<h3 style='margin: 0;'>" . __("Search Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Search Results Layout", "Avada"),
			"desc" => __("Select the layout for the search results page.", "Avada"),
			"id" => "search_layout",
			"std" => "Grid",
			"type" => "select",
			"options" => array(
				'Large' => 'Large',
				'Medium' => 'Medium',
				'Large Alternate' => 'Large Alternate',
				'Medium Alternate' => 'Medium Alternate',
				'Grid' => 'Grid',
				'Timeline' => 'Timeline'
			));

		$of_options[] = array( "name" => __("Search Results Content", "Avada"),
			"desc" => __("Select the type of content to display in search results.", "Avada"),
			"id" => "search_content",
			"std" => "Posts and Pages",
			"type" => "select",
			"options" => array('Posts and Pages' => 'Posts and Pages', 'Only Posts' => 'Only Posts', 'Only Pages' => 'Only Pages'));

		$of_options[] = array( "name" => __("Hide Search Results Excerpt", "Avada"),
			"desc" => __("Check the box if you want to hide excerpt for search results.", "Avada"),
			"id" => "search_excerpt",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Number of Search Results Per Page", "Avada"),
			"desc" => __("Set the number of search results per page.", "Avada"),
			"id" => "search_results_per_page",
			"std" => "10",
			"type" => "text");

		$of_options[] = array( "name" => __("Hide Featured Images from Search Results", "Avada"),
			"desc" => __("Check the box if you want to hide featured images for search results.", "Avada"),
			"id" => "search_featured_images",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Search Field Position", "Avada"),
			"desc" => __("Select the position of the search bar on the search results page.", "Avada"),
			"id" => "search_new_search_position",
			"std" => "top",
			"type" => "select",
			"options" => array('top' => 'Above Search Results', 'bottom' => 'Below Search Results', 'hidden' => 'Hide'));

// Theme Specific Options
		$of_options[] = array( "name" => __("Extra", "Avada"),
			"id" => "heading_extra",
			"type" => "heading");

		$of_options[] = array( "name" => __("Misc Options", "Avada"),
			"desc" => "",
			"id" => "misc_options",
			"std" => "<h3 style='margin: 0;'>" . __("Miscellaneous Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Sidenav Behavior", "Avada"),
			"desc" => __("Controls the side navigation animation for child pages, on click or hover.", "Avada"),
			"id" => "sidenav_behavior",
			"std" => "hover",
			"options" => array('Hover' => 'Hover', 'Click' => 'Click'),
			"type" => "select");

		$of_options[] = array(
			"name" => __("Image Placeholders", "Avada"),
			"desc" => __("Check the box to enable the showing of posts without a featured image on portfolio archives and related posts/projects carousels.", "Avada"),
			"id" => "featured_image_placeholder",
			"std" => 1,
			"type" => "checkbox");

		  $of_options[] = array( "name" => __("Basis for Excerpt Length", "Avada"),
			"desc" => __("Choose if the excerpt length should be based on words or characters.", "Avada"),
			"id" => "excerpt_base",
			"std" => "words",
			"options" => array('Words' => 'Words', 'Characters' => 'Characters'),
			"type" => "select");

		$of_options[] = array( "name" => __("Disable [...] on Excerpts", "Avada"),
			"desc" => __("Check the box to disable the read more sign [...] on excerpts throughout the site.", "Avada"),
			"id" => "disable_excerpts",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Make [...] Link to Single Post Page", "Avada"),
			"desc" => __("Check the box to have the read more sign [...] on excerpts link to single post page.", "Avada"),
			"id" => "link_read_more",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Allow Comments on Pages", "Avada"),
			"desc" => __("Check the box to allow comments on regular pages.", "Avada"),
			"id" => "comments_pages",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Featured Images on Pages", "Avada"),
			"desc" => __("Check the box to disable featured images on regular pages.", "Avada"),
			"id" => "featured_images_pages",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("FAQ Featured Images", "Avada"),
			"desc" => __("Check the box to show featured images on FAQ archive page.", "Avada"),
			"id" => "faq_featured_image",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("FAQ Filters", "Avada"),
			"desc" => __("Choose to show or hide filters, or to display them without 'All'.", "Avada"),
			"id" => "faq_filters",
			"std" => 'show',
			"options" => array('yes' => 'Show', 'yes_without_all' => 'Show without "All"', 'no' => 'Hide'),
			"type" => "select");

		$of_options[] = array( "name" => __("Add 'nofollow' to social links", "Avada"),
			"desc" => __("Check to add 'nofollow' attribute to all social links.", "Avada"),
			"id" => "nofollow_social_links",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Open Social Icons in a New Window", "Avada"),
			"desc" => __("Check the box to allow social icons to open in a new window.", "Avada"),
			"id" => "social_icons_new",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Form Input and Select Height", "Avada"),
			"desc" => __("This option controls the height of all search, form input and select fields. ex: 20px.", "Avada"),
			"id" => "form_input_height",
			"std" => "29px",
			"type" => "text");

		$of_options[] = array( "name" => __("WordPress jpeg Quality", "Avada"),
			"desc" 		=> __("This option controls the quality of the generated image sizes for every uploaded image. Ranges between 0 and 100 percent. Higher values lead to better image qualities but also higher file sizes.<br />NOTE: After changing this value, please (install and) run", "Avada" ) . ' <a href="' . admin_url() . 'plugin-install.php?tab=plugin-information&amp;plugin=regenerate-thumbnails&amp;TB_iframe=true&amp;width=830&amp;height=472" class="thickbox" title="' . __( "Regenerate Thumbnails", "Avada" ) . '">' . __( "Regenerate Thumbnails", "Avada" ) .'</a>',
			"id" 		=> "pw_jpeg_quality",
			"std" 		=> "90",
			"min" 		=> "1",
			"step"		=> "1",
			"max" 		=> "100",
			"edit"		=> "yes",
			"type" 		=> "sliderui"
		);

		$of_options[] = array( "name" => __( "Related Posts / Projects", "Avada" ),
			"desc" => "",
			"id" => "related_posts",
			"std" => "<h3 style='margin: 0;'>" . __( "Related Posts / Projects", "Avada" ) . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Number of Related Posts / Projects", "Avada"),
			"desc" => __("This option controls the amount of related posts / projects that show up on each single portfolio and blog post. ex: 5", "Avada"),
			"id" => "number_related_posts",
			"std" => "5",
			"type" => "text");

		$of_options[] = array( "name" => __("Related Posts / Projects Maximum Columns", "Avada"),
			"desc" => __("Select the number of max columns to display.", "Avada"),
			"id" => "related_posts_columns",
			"std" => "5",
			"options" => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6'),
			"type" => "select");

		$of_options[] = array( "name" => __("Related Posts / Projects Column Spacing", "Avada"),
			"desc" => __("Insert the amount of spacing between items without 'px'. ex: 40", "Avada"),
			"id" => "related_posts_column_spacing",
			"std" => "44",
			"type" => "text");

		$of_options[] = array( "name" => __("Related Posts / Projects Layout", "Avada"),
			"desc" => __("Choose to show titles on rollover image, or below image.", "Avada"),
			"id" => "related_posts_layout",
			"std" => "title_on_rollover",
			"type" => "select",
			"options" => array(
				'title_on_rollover' => 'Title on rollover',
				'title_below_image' => 'Title below image',
			));

		$of_options[] = array( "name" => __("Related Posts / Projects Image Size", "Avada"),
			"desc" => __("Choose if the images are fixed (cropped) or auto (full image ratio) for related posts / projects. IMPORTANT: Fixed images work best with smaller site widths. Auto images work best with larger site widths.", "Avada"),
			"id" => "related_posts_image_size",
			"std" => "cropped",
			"type" => "select",
			"options" => array(
				'cropped' => 'Fixed',
				'full' => 'Auto',
			));

		$of_options[] = array( "name" => __("Related Posts / Projects Autoplay", "Avada"),
			"desc" => __("Check the box to enable to autoplay on the carousel.", "Avada"),
			"id" => "related_posts_autoplay",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Related Posts / Projects Speed", "Avada"),
			"desc" => __("Controls the speed of all carousel elements.  ex: 1000 = 1 second.", "Avada"),
			"id" => "related_posts_speed",
			"std" => "2500",
			"type" => "text");

		$of_options[] = array( "name" => __("Related Posts / Projects Show Navigation", "Avada"),
			"desc" => __("Check the box to enable navigation buttons on the carousel.", "Avada"),
			"id" => "related_posts_navigation",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Related Posts / Projects Mouse Scroll", "Avada"),
			"desc" => __("Check the box to enable mouse drag control on the carousel.", "Avada"),
			"id" => "related_posts_swipe",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Related Posts / Projects Scroll Items", "Avada"),
			"desc" => __("Insert the amount of items to scroll. Leave empty to scroll number of visible items.", "Avada"),
			"id" => "related_posts_swipe_items",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Rollover", "Avada"),
			"desc" => "",
			"id" => "rollovers",
			"std" => "<h3 style='margin: 0;'>" . __("Image Rollover Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Image Rollover", "Avada"),
			"desc" => __("Check the box to show the rollover box on images.", "Avada"),
			"id" => "image_rollover",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Rollover Image Direction", "Avada"),
			"desc" => __("Select from which direction the rollover should start.", "Avada"),
			"id" => "image_rollover_direction",
			"std" => 'left',
			"options" => array('fade' => 'Fade', 'left' => 'Left', 'right' => 'Right', 'bottom' => 'Bottom', 'top' => 'Top', 'center_horiz' => 'Center Horizontal', 'center_vertical' => 'Center Vertical'),
			"type" => "select");

		$of_options[] = array( "name" => __("Rollover Image Icon Font Size", "Avada"),
			"desc" => __("Controls the font size of the icons in the rollover. In pixels, default is 15.", "Avada"),
			"id" => "image_rollover_icon_size",
			"std" => "15",
			"type" => "text");

		$of_options[] = array( "name" => __("Disable Link Icon From Image Rollover", "Avada"),
			"desc" => __("Check the box to disable the link icon from image rollovers.", "Avada"),
			"id" => "link_image_rollover",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Image Icon From Image Rollover", "Avada"),
			"desc" => __("Check the box to disable the image icon from image rollovers.", "Avada"),
			"id" => "zoom_image_rollover",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Title From Image Rollover", "Avada"),
			"desc" => __("Check the box to disable the title from image rollovers.", "Avada"),
			"id" => "title_image_rollover",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Categories From Image Rollover", "Avada"),
			"desc" => __("Check the box to disable the categories from image rollovers.", "Avada"),
			"id" => "cats_image_rollover",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Icon Circle From Image Rollover", "Avada"),
			"desc" => __("Check the box to disable the icon circle from images.", "Avada"),
			"id" => "icon_circle_image_rollover",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Pagination Options", "Avada"),
			"desc" => "",
			"id" => "rollovers",
			"std" => "<h3 style='margin: 0;'>" . __("Pagination Options", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Pagination Box Padding", "Avada"),
			"desc" => __("Controls the padding inside the box, ex: 10px or 10%.", "Avada"),
			"id" => "pagination_box_padding",
			"std" => "2px 6px",
			"type" => "text");

		$of_options[] = array( "name" => __("Pagination Text Display", "Avada"),
			"desc" => __("Controls if \"Previous\" and \"Next\" text is displayed or not.", "Avada"),
			"id" => "pagination_text_display",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Advanced", "Avada"),
			"id" => "heading_advanced",
			"type" => "heading");

		$of_options[] = array( "name" => __("enable_disable_heading", "Avada"),
			"desc" => "",
			"id" => "enable_disable_heading",
			"std" => "<h3 style='margin: 0;'>" . __("Enable / Disable Theme Features & Plugin Support", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array(
			"name" => __("Disable Smooth Scrolling", "Avada"),
			"desc" => __("Check to disable smooth scrolling. This will remove the dark scrollbar and revert to the default browser scrollbar style.", "Avada"),
			"id" => "smooth_scrolling",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Fusion Builder", "Avada"),
			"desc" => __("Check to disable the fusion builder button on pages/posts.", "Avada"),
			"id" => "disable_builder",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Code Block Encoding", "Avada"),
			"desc" => __("Check to disable encoding in the Fusion Builder code block element.", "Avada"),
			"id" => "disable_code_block_encoding",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Mega Menu", "Avada"),
			"desc" => __("Check to disable the theme's mega menu.", "Avada"),
			"id" => "disable_megamenu",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Avada Styles For Revolution Slider", "Avada"),
			"desc" => __("Check the box to disable the Avada styles and use the default Revolution Slider styles.", "Avada"),
			"id" => "avada_rev_styles",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Avada Dropdown Styles", "Avada"),
			"desc" => __("Check the box to disable the Avada styles for dropdown/select fields site wide. This should be done if you experience any issues with 3rd party plugin dropdowns.", "Avada"),
			"id" => "avada_styles_dropdowns",
			"std" => 0,
			"type" => "checkbox");


		$of_options[] = array( "name" => __("Disable CSS Animations", "Avada"),
			"desc" => __("Check the box to disable CSS animations on shortcode items.", "Avada"),
			"id" => "use_animate_css",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable CSS Animations on Mobiles Only", "Avada"),
			"desc" => __("Check the box to disable CSS animations on mobiles only.", "Avada"),
			"id" => "disable_mobile_animate_css",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable CSS Image Hover Animations on Mobiles", "Avada"),
			"desc" => __("Check the box to disable CSS image hover animations on mobiles.", "Avada"),
			"id" => "disable_mobile_image_hovers",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Youtube API Scripts", "Avada"),
			"desc" => __("Check the box to disable Youtube API scripts.", "Avada"),
			"id" => "status_yt",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Vimeo API Scripts", "Avada"),
			"desc" => __("Check the box to disable Vimeo API scripts.", "Avada"),
			"id" => "status_vimeo",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Google Map Scripts", "Avada"),
			"desc" => __("Check the box to disable google map.", "Avada"),
			"id" => "status_gmap",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable ToTop Script", "Avada"),
			"desc" => __("Check the box to disable the ToTop script which adds the scrolling to top functionality.", "Avada"),
			"id" => "status_totop",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Enable ToTop Script on mobile", "Avada"),
			"desc" => __("Check the box to enable the ToTop script on mobile devices.", "Avada"),
			"id" => "status_totop_mobile",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Fusion Slider", "Avada"),
			"desc" => __("Check the box to disable fusion slider.", "Avada"),
			"id" => "status_fusion_slider",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Elastic Slider", "Avada"),
			"desc" => __("Check the box to disable elastic slider.", "Avada"),
			"id" => "status_eslider",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable FontAwesome", "Avada"),
			"desc" => __("Check the box to disable font awesome.", "Avada"),
			"id" => "status_fontawesome",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Open Graph Meta Tags", "Avada"),
			"desc" => __("Check the box to disable open graph meta tags which is mainly used when sharing pages on social networking sites like Facebook.", "Avada"),
			"id" => "status_opengraph",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Rich Snippets Sitewide", "Avada"),
			"desc" => __("Check the box to disable rich snippets data sitewide.", "Avada"),
			"id" => "disable_date_rich_snippet_pages",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Avada's Woocommerce Product Gallery Slider", "Avada"),
			"desc" => __("Enable / disable product gallery slider that is built-in with Avada. This is only useful for plugin compatibility.", "Avada"),
			"id" => "disable_woo_gallery",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Activate Developers Mode", "Avada"),
			"desc" => __("<strong>Notice:</strong> By default, all the javascript files are combined and minified. Activating this mode will load non-combined and non-minified javascript files, which is used for development only. This will have an impact on the performance of your site.", "Avada"),
			"id" => "dev_mode",
			"std" => 0,
			"type" => "checkbox");


		$of_options[] = array( "name" => __("Dynamic CSS", "Avada"),
			"desc" => "",
			"id" => "dynamic_css_compiler_heading",
			"std" => "<h3 style='margin: 0;'>Dynamic CSS</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Activate Compiler", "Avada"),
			"desc" => __('Check the box to compile the dynamic CSS within the tag into a file. Please note that a separate file will be created for each of your pages & posts inside of the uploads/avada-styles folder.', "Avada"),
			"id" => "dynamic_css_compiler",
			"std" => 0,
			"type" => "checkbox");

		$count_posts = wp_count_posts( 'post' );
		$count_pages = wp_count_posts( 'page' );
		$count_totals = ( intval( $count_posts->publish ) + intval( $count_pages->publish ) );

		$of_options[] = array( "name" => __("Enable db-caching for dynamic CSS", "Avada"),
			"desc" => __('Check the box to enable caching the dynamic CSS in your database.', "Avada"),
			"id" => "dynamic_css_db_caching",
			"std" => ( 200 < $count_totals ) ? 0 : 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Advanced: Cache Server IP", "Avada"),
			"desc" => __("For unique cases where you are using cloudflare and a cache server e.g. Varnish. Please enter your cache server IP to clear the theme options dynamic CSS cache. Please consult with your server admin for help.", "Avada"),
			"id" => "cache_server_ip",
			"std" => "",
			"type" => "text");

		$of_options[] = array( "name" => __("Dynamic CSS", "Avada"),
			"desc" => "",
			"id" => "dynamic_css_compiler_heading",
			"std" => "<h3 style='margin: 0;'>" . __("Dynamic CSS.", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("WooCommerce", "Avada"),
			"id" => "heading_woocommerce",
			"type" => "heading");

		$of_options[] = array( "name" => __("WooCommerce Product Box Design", "Avada"),
			"desc" => __("Select the design for the product boxes. This will automatically alter the grid element and grid box colors.", "Avada"),
			"id" => "woocommerce_product_box_design",
			"std" => "classic",
			"type" => "select",
			"options" => array(
				"classic" => "Classic",
				"clean" => "Clean"
				)
			);

		$of_options[] = array( "name" => __("Woocommerce Number of Products per Page", "Avada"),
			"desc" => __("Insert the number of products to display per page.", "Avada"),
			"id" => "woo_items",
			"std" => "12",
			"type" => "text");

		$of_options[] = array( "name" => __("Woocommerce Number of Product Columns", "Avada"),
			"desc" => __("Select the number of columns for the main shop page.", "Avada"),
			"id" => "woocommerce_shop_page_columns",
			"std" => "4",
			"type" => "select",
			"options" => array(
				  "1" => "1",
				  "2" => "2",
				  "3" => "3",
				  "4" => "4",
				  "5" => "5",
				  "6" => "6",
			)
		);

		$of_options[] = array( "name" => __("Woocommerce Related/Up-Sell/Cross-Sell Product Number of Columns", "Avada"),
			"desc" => __("Select the number of columns for the related and up-sell products on single post pages and cross-sells on cart page.", "Avada"),
			"id" => "woocommerce_related_columns",
			"std" => "4",
			"type" => "select",
			"options" => array(
				  "1" => "1",
				  "2" => "2",
				  "3" => "3",
				  "4" => "4",
				  "5" => "5",
				  "6" => "6",
			)
		);

		$of_options[] = array( "name" => __("Woocommerce Archive/Category Number of Product Columns", "Avada"),
			"desc" => __("Select the number of columns for the archive/category pages.", "Avada"),
			"id" => "woocommerce_archive_page_columns",
			"std" => "3",
			"type" => "select",
			"options" => array(
				  "1" => "1",
				  "2" => "2",
				  "3" => "3",
				  "4" => "4",
						"5" => "5",
						"6" => "6",
			)
		);

		$of_options[] = array( "name" => __("WooCommerce Product Tab Design", "Avada"),
			"desc" => __("Choose if the product tabs on the single product page are vertical or horizontal.", "Avada"),
			"id" => "woocommerce_product_tab_design",
			"std" => "vertical",
			"type" => "select",
			"options" => array(
				"horizontal" => "Horizontal Tabs",
				"vertical" => "Vertical Tabs"
				)
			);

		$of_options[] = array( "name" => __("Disable Woocommerce Shop Page Ordering Boxes", "Avada"),
			"desc" => __("Check the box to disable the ordering boxes displayed on the shop page.", "Avada"),
			"id" => "woocommerce_avada_ordering",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Disable Woocommerce Shop Page Crossfade Image Effect", "Avada"),
			"desc" => __("Check the box to disable the product crossfade image effect on the shop page.", "Avada"),
			"id" => "woocommerce_disable_crossfade_effect",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Use Woocommerce One Page Checkout", "Avada"),
			"desc" => __("Check the box to use Avada's one page checkout template.", "Avada"),
			"id" => "woocommerce_one_page_checkout",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Woocommerce Order Notes on Checkout", "Avada"),
			"desc" => __("Check the box to show the order notes on the checkout page.", "Avada"),
			"id" => "woocommerce_enable_order_notes",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("WooCommerce Menu Cart Icon Counter", "Avada"),
			"desc" => __("Choose to show or hide the cart counter circle.", "Avada"),
			"id" => "woocommerce_cart_counter",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Woocommerce My Account Link in Main Menu", "Avada"),
			"desc" => __("Check the box to show My Account link, uncheck to disable. Please note these will not show with Ubermenu.", "Avada"),
			"id" => "woocommerce_acc_link_main_nav",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Woocommerce Cart Icon in Main Menu", "Avada"),
			"desc" => __("Check the box to show the Cart icon, uncheck to disable. Please note these will not show with Ubermenu.", "Avada"),
			"id" => "woocommerce_cart_link_main_nav",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Woocommerce My Account Link in Secondary Menu", "Avada"),
			"desc" => __("Check the box to show My Account link, uncheck to disable. Only works if a top menu is assigned in header content 1-2.  Not compatible with Ubermenu.", "Avada"),
			"id" => "woocommerce_acc_link_top_nav",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Woocommerce Cart Icon in Secondary Menu", "Avada"),
			"desc" => __("Check the box to show the Cart icon, uncheck to disable. Only works if a top menu is assigned in header content 1-2.  Not compatible with Ubermenu. ", "Avada"),
			"id" => "woocommerce_cart_link_top_nav",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Show Woocommerce Social Icons", "Avada"),
			"desc" => __("Check the box to show the social icons on product pages, uncheck to disable.", "Avada"),
			"id" => "woocommerce_social_links",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Product Grid / List View", "Avada"),
			"desc" => __("Select the box to display the grid/list toggle on the main shop page and category/archive shop pages.", "Avada"),
			"id" => "woocommerce_toggle_grid_list",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Account Area Message 1", "Avada"),
			"desc" => __("Insert your text and it will appear in the first message box on the acount page.", "Avada"),
			"id" => "woo_acc_msg_1",
			"std" => "Need Assistance? Call customer service at 888-555-5555.",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Account Area Message 2", "Avada"),
			"desc" => __("Insert your text and it will appear in the second message box on the acount page.", "Avada"),
			"id" => "woo_acc_msg_2",
			"std" => "E-mail them at info@yourshop.com",
			"type" => "textarea");

		$of_options[] = array( "name" => __("bbPress", "Avada"),
			"id" => "heading_bbpress",
			"type" => "heading");

		$of_options[] = array( "name" => __("bbPress Forum Header Background Color", "Avada"),
			"desc" => __("Controls the background color for forum header rows.", "Avada"),
			"id" => "bbp_forum_header_bg",
			"std" => "#ebeaea",
			"type" => "color");

		$of_options[] = array( "name" => __("bbPress Forum Header Font Color", "Avada"),
			"desc" => __("CControls the font color for the text in the forum header rows.", "Avada"),
			"id" => "bbp_forum_header_font_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("bbPress Forum Border Color", "Avada"),
			"desc" => __("Controls the border color for all forum surrounding borders.", "Avada"),
			"id" => "bbp_forum_border_color",
			"std" => "#ebeaea",
			"type" => "color");

		$of_options[] = array( "name" => __("BBPress/BuddyPress", "Avada"),
			"desc" => "",
			"id" => "bbpress_sidebars",
			"std" => "<h3 style='margin: 0;'>" . __("BBPress/BuddyPress", "Avada") . "</h3>",
			"icon" => true,
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Activate Global Sidebar", "Avada"),
			"desc" => __("Check the box if you want to use global sidebars on all forum pages. Forums index page, profile page and search page does not need this option checked to display the sidebars selected below.", "Avada"),
			"id" => "bbpress_global_sidebar",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Global Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on forum and BuddyPress pages globally.", "Avada"),
			"id" => "ppbress_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on forum and BuddyPress pages globally. Sidebar 2 can only be used if sidebar 1 is selected.", "Avada"),
			"id" => "ppbress_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global bbPress/BuddyPress Sidebar Position", "Avada"),
			"desc" => __("Select the sidebar 1 position for bbPress/BuddyPress pages. If sidebar 2 is selected, it will display on the opposite side.", "Avada"),
			"id" => "bbpress_sidebar_position",
			"std" => "Right",
			"type" => "select",
			"options" => array(
				'Right' => 'Right',
				'Left' => 'Left',
			));

		$of_options[] = array( "name" => __("BBPress", "Avada"),
			"desc" => "",
			"id" => "bbpress_sidebars",
			"std" => "<h3 style='margin: 0;'>" . __("BBPress", "Avada") . "</h3>",
			"icon" => true,
			"position" => "end",
			"type" => "accordion");


		$of_options[] = array( "name" => __("Events Calendar", "Avada"),
			"id" => "heading_ec",
			"type" => "heading");

		$of_options[] = array( "name" => __("Primary Color Overlay Text Color", "Avada"),
			"desc" => __("Text color for when primary color is in the background.", "Avada"),
			"id" => "primary_overlay_text_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Events Filter Bar Background Color", "Avada"),
			"desc" => __("Controls the background color for the events calendar filter bar.", "Avada"),
			"id" => "ec_bar_bg_color",
			"std" => "#efeded",
			"type" => "color");

		$of_options[] = array( "name" => __("Event Filter Bar Text Color", "Avada"),
			"desc" => __("Controls the color of the event filter bar text.", "Avada"),
			"id" => "ec_bar_text_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Monthly Calendar Heading Background Color", "Avada"),
			"desc" => __("Controls the background color for the numbered heading.", "Avada"),
			"id" => "ec_calendar_heading_bg_color",
			"std" => "#b2b2b2",
			"type" => "color");

		$of_options[] = array( "name" => __("Monthly Calendar Background Color", "Avada"),
			"desc" => __("Controls the background color of each day in the calendar.", "Avada"),
			"id" => "ec_calendar_bg_color",
			"std" => "#b2b2b2",
			"type" => "color");

		$of_options[] = array( "name" => __("Tooltip Background Color", "Avada"),
			"desc" => __("Controls the background color for the event tooltip.", "Avada"),
			"id" => "ec_tooltip_bg_color",
			"std" => "#ffffff",
			"type" => "color");

		$of_options[] = array( "name" => __("Tooltip Body Text Color", "Avada"),
			"desc" => __("Controls the body text color of the tooltip.", "Avada"),
			"id" => "ec_tooltip_body_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Border Color", "Avada"),
			"desc" => __("Controls the various border color around events calendar.", "Avada"),
			"id" => "ec_border_color",
			"std" => "#e0dede",
			"type" => "color");

		$of_options[] = array( "name" => __("Featured Image Hover Type", "Avada"),
			"desc" => __("Choose the hover type for featured images.", "Avada"),
			"id" => "ec_hover_type",
			"std" => "none",
			"type" => "select",
			"options" => array( 'none' => 'none', 'zoomin' => 'Zoom In', 'zoomout' => 'Zoom Out', 'liftup' => 'Lift Up' ));

		$of_options[] = array( "name" => __("Image Background Size For List View", "Avada"),
			"desc" => __("Select if the event image displays auto or covered in the list view. All other areas show the image as auto.", "Avada"),
			"id" => "ec_bg_list_view",
			"std" => "cover",
			"type" => "select",
			"options" => array( 'cover' => 'cover', 'auto' => 'auto' ));

	   $of_options[] = array( "name" => __("Single Event Detail Section", "Avada"),
			"desc" => "",
			"id" => "ec_single_event_detail_section_heading",
			"std" => "<h3 style='margin: 0;'>" . __("Single Event Detail Section", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Social Sharing Box", "Avada"),
			"desc" => __("Check the box to display the social sharing box.", "Avada"),
			"id" => "events_social_sharing_box",
			"std" => 1,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Sidebar Background Color", "Avada"),
			"desc" => __("Controls the background color of the sidebar.", "Avada"),
			"id" => "ec_sidebar_bg_color",
			"std" => "#f6f6f6",
			"type" => "color");

		$of_options[] = array( "name" => __("Sidebar Padding", "Avada"),
			"desc" => __("Enter a pixel or percentage based value, ex: 5px or 5%", "Avada"),
			"id" => "ec_sidebar_padding",
			"std" => "4%",
			"type" => "text");

		$of_options[] = array( "name" => __("Sidebar Widget Heading Font Size", "Avada"),
			"desc" => __("In pixels, default is 13", "Avada"),
			"id" => "ec_sidew_font_size",
			"std" => "17",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Sidebar Widget Title Background Color", "Avada"),
			"desc" => __("Controls the background color of the sidebar widget title.", "Avada"),
			"id" => "ec_sidebar_widget_bg_color",
			"std" => "#aoce4e",
			"type" => "color");

		$of_options[] = array( "name" => __("Sidebar Widget Headings Color", "Avada"),
			"desc" => __("Controls the text color of the sidebar widget headings.", "Avada"),
			"id" => "ec_sidebar_heading_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Sidebar Text Font Size", "Avada"),
			"desc" => __("In pixels, default is 14", "Avada"),
			"id" => "ec_text_font_size",
			"std" => "14",
						"min" 		=> "1",
						"step"		=> "1",
						"max" 		=> "100",
						"edit"		=> "yes",
						"type" 		=> "sliderui"
				);

		$of_options[] = array( "name" => __("Sidebar Text Color", "Avada"),
			"desc" => __("Controls the text color of the sidebar.", "Avada"),
			"id" => "ec_sidebar_text_color",
			"std" => "#747474",
			"type" => "color");

		$of_options[] = array( "name" => __("Sidebar Link Color", "Avada"),
			"desc" => __("Controls the link color of the sidebar.", "Avada"),
			"id" => "ec_sidebar_link_color",
			"std" => "#333333",
			"type" => "color");

		$of_options[] = array( "name" => __("Sidebar Divider Color", "Avada"),
			"desc" => __("Controls the divider color of the sidebar.", "Avada"),
			"id" => "ec_sidebar_divider_color",
			"std" => "#e8e8e8",
			"type" => "color");
	   $of_options[] = array( "name" => __("Single Event Detail Section", "Avada"),
			"desc" => "",
			"id" => "ec_single_event_detail_section_heading",
			"std" => "<h3 style='margin: 0;'>" . __("Single Event Detail Section", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Events Content + Sidebar Width", "Avada"),
			"desc" => "",
			"id" => "ec_content_sidebar_width",
			"std" => "<h3 style='margin: 0;'>" . __("Events Content + Sidebar Width", "Avada") . "</h3><p>" . __("These settings are used on pages with 1 sidebar. Total values must add up to 100.", "Avada") . "</p>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Sidebar Width", "Avada"),
			"desc" => __("Controls the width of the sidebar. In px or %, ex: 100% or 1170px.", "Avada"),
			"id" => "ec_sidebar_width",
			"std" => "32%",
			"type" => "text");

	   $of_options[] = array( "name" => __("Events Content + Sidebar Width", "Avada"),
			"desc" => "",
			"id" => "ec_content_sidebar_width",
			"std" => "<h3 style='margin: 0;'>" . __("Events Content + Sidebar Width", "Avada") . "</h3><p>" . __("These settings are used on pages with 1 sidebar. Total values must add up to 100.", "Avada") . "</p>",
			"position" => "end",
			"type" => "accordion");

	   $of_options[] = array( "name" => __("Events Content + Sidebar + Sidebar Width", "Avada"),
			"desc" => "",
			"id" => "ec_content_sidebar_sidebar_width",
			"std" => "<h3 style='margin: 0;'>" . __("Events Content + Sidebar + Sidebar Width", "Avada") . "</h3><p>" . __("These settings are used on pages with 2 sidebars. Total values must add up to 100.", "Avada") . "</p>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Sidebar 1 Width", "Avada"),
			"desc" => __("Controls the width of the sidebar 1. In px or %, ex: 100% or 1170px.", "Avada"),
			"id" => "ec_sidebar_2_1_width",
			"std" => "21%",
			"type" => "text");

		$of_options[] = array( "name" => __("Sidebar 2 Width", "Avada"),
			"desc" => __("Controls the width of the sidebar 2. In px or %, ex: 100% or 1170px.", "Avada"),
			"id" => "ec_sidebar_2_2_width",
			"std" => "21%",
			"type" => "text");

	   $of_options[] = array( "name" => __("Events Content + Sidebar + Sidebar Width", "Avada"),
			"desc" => "",
			"id" => "ec_content_sidebar_sidebar_width",
			"std" => "<h3 style='margin: 0;'>" . __("Events Content + Sidebar + Sidebar Width", "Avada") . "</h3><p>" . __("These settings are used on pages with 2 sidebars. Total values must add up to 100.", "Avada") . "</p>",
			"position" => "end",
			"type" => "accordion");


	   $of_options[] = array( "name" => __("Events Global Sidebar", "Avada"),
			"desc" => "",
			"id" => "ec_global_sidebar_heading",
			"std" => "<h3 style='margin: 0;'>" . __("Events Global Sidebar", "Avada") . "</h3>",
			"position" => "start",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Activate Global Sidebar", "Avada"),
			"desc" => __("Check the box if you want to use a global sidebar on all event pages. This option overrides the page options.", "Avada"),
			"id" => "ec_global_sidebar",
			"std" => 0,
			"type" => "checkbox");

		$of_options[] = array( "name" => __("Global Sidebar 1", "Avada"),
			"desc" => __("Select sidebar 1 that will display on all event pages.", "Avada"),
			"id" => "ec_sidebar",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Sidebar 2", "Avada"),
			"desc" => __("Select sidebar 2 that will display on all event pages. Sidebar 2 can only be used if sidebar 1 is selected", "Avada"),
			"id" => "ec_sidebar_2",
			"std" => "None",
			"type" => "select",
			"options" => $sidebar_options
		);

		$of_options[] = array( "name" => __("Global Sidebar Position", "Avada"),
			"desc" => __("Select the sidebar 1 position for event pages. If sidebar 2 is selected, it will display on the opposite side.", "Avada"),
			"id" => "ec_sidebar_pos",
			"std" => "Right",
			"options" => array('Right' => 'Right', 'Left' => 'Left'),
			"type" => "select");

	   $of_options[] = array( "name" => __("Events Global Sidebar", "Avada"),
			"desc" => "",
			"id" => "ec_global_sidebar_heading",
			"std" => "<h3 style='margin: 0;'>" . __("Events Global Sidebar", "Avada") . "</h3>",
			"position" => "end",
			"type" => "accordion");

		$of_options[] = array( "name" => __("Custom CSS", "Avada"),
			"id" => "heading_custom_css",
			"type" => "heading");

		$of_options[] = array( "name" => __("Advanced CSS Customizations", "Avada"),
			"desc" => "",
			"id" => "advanced_css_intro",
			"std" => "<h3 style='margin: 0;'>" . __("Advanced CSS Customizations", "Avada") . "</h3>",
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("Custom CSS Info", "Avada"),
			"desc" => "",
			"id" => "custom_css_info",
			"std" => __("Paste your CSS code, do not include any tags or HTML in the field. Any custom CSS entered here will override the theme CSS. In some cases, the !important tag may be needed. Don't URL encode image or svg paths. Contents of this field will be auto encoded.", "Avada"),
			"icon" => true,
			"type" => "info");

		$of_options[] = array( "name" => __("CSS Code", "Avada"),
			"desc" => "",
			"id" => "custom_css",
			"std" => "",
			"type" => "textarea");

		$of_options[] = array( "name" => __("Backup", "Avada"),
			"id" => "heading_backup",
			"type" => "heading");

		$of_options[] = array( "name" => __("Backup and Restore Options", "Avada"),
			"id" => "of_backup",
			"std" => "",
			"type" => "backup",
			"desc" => __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'Avada'),
		);

		$of_options[] = array( "name" => __("Transfer Theme Options Data", "Avada"),
			"id" => "of_transfer",
			"std" => "",
			"type" => "transfer",
			"desc" => __("Import Options", "Avada"),
		);

		return $of_options;
	}
}

if (!function_exists('of_options'))
{
	  function of_options()
	  {
		global $of_options;

		$of_options = of_options_array();
		// End Avada Edit
	  }//End function: of_options()
}//End chack if function exists: of_options()


// Omit closing PHP tag to avoid "Headers already sent" issues.
