<!DOCTYPE HTML>
<html>
	<head>
		<title>Agritech</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="AGRITECH, plateforme de marché d'échange entre les agriculteurs, les acheteurs et les povoirs publiques'">
    	<meta name="keywords" content="AGRITECH, technique, achat, vente, produits, production, agriculture, acheteurs, pourvoir publiques, météo, Niger, Afrique">
		<meta name="author" content="Lim Consulting, IsofLab">
		<!--[if lte IE 8]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script><![endif]-->
		{{ HTML::script('assets/templated-spatial/js/jquery.min.js') }}
		{{ HTML::script('assets/templated-spatial/js/skel.min.js') }}
		{{ HTML::script('assets/templated-spatial/js/skel-layers.min.js') }}
		{{ HTML::script('assets/templated-spatial/js/init.js') }}
		<noscript>
			{{ HTML::style('assets/templated-spatial/css/skel.css') }}
			{{ HTML::style('assets/templated-spatial/css/style.css') }}
			{{ HTML::style('assets/templated-spatial/css/style-xlarge.css') }}
		</noscript>
		
		<link rel="apple-touch-icon" href="{{ URL::to('/') }}/assets/images/favicons/apple-icon.png">
    	<link rel="icon" href="{{ URL::to('/') }}/assets/images/favicons/favicon.ico">
	</head>
	<body class="landing">
		<!-- Header -->
			<header id="header" class="alt">
				<h1><strong><a href="index.html">Agritech</a></strong> by Agritec</h1>
				<nav id="nav">
					<ul>
						<li><a href="{{ URL::to('/') }}">Agritech</a></li>
						<li><a href="{{ URL::to('/login') }}">Vous connecter</a></li>
						<li><a href="{{ URL::to('/register') }}">Nous rejoindre</a></li>
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner">
				<img src="{{ URL::to('/') }}/assets/images/agritech-logo.png" alt="AGRITECH" />
				<p>Bienvenue sur Agritech <br /> La plateforme de travail unifiée entre les acteurs du monde agricole : agriculteurs, professionnels (ONG, acheteurs, statisticiens, économistes, ...) et les pouvoirs publiques.</p>
				<ul class="actions">
					<li><a href="#three" class="button special big">Fonctionnalités</a></li>
				</ul>
			</section>

			
			<!-- Three -->
				<section id="three" class="wrapper style1">
					<div class="container">
						<header class="major special">
							<h2>Fonctionnalités</h2>
							<p>La plateforme Agritech offre les fonctionnailités suivantes</p>
						</header>
						<div class="feature-grid">
							<div class="feature">
								<div class="image rounded"><img src="{{ URL::to('/') }}/assets/templated-spatial/images/agriculteur.jpg" alt="Agriculteur" /></div>
								<div class="content">
									<header>
										<h4>Agriculteurs</h4>
										<p>Cultivateurs et éleveurs</p>
									</header>
									<p>Gérer : ses productions, ses exploitations, prix de sa production en ligne ou par simple envoie de SMS; Alertes SMS</p>
								</div>
							</div>
							<div class="feature">
								<div class="image rounded"><img src="{{ URL::to('/') }}/assets/templated-spatial/images/professionel.jpg" alt="" /></div>
								<div class="content">
									<header>
										<h4>Professionels agricoles</h4>
										<p>ONG, statisticiens, économistes, ...</p>
									</header>
									<p>Accès aux statistiques sur la production agricole</p>
								</div>
							</div>
							<div class="feature">
								<div class="image rounded"><img src="{{ URL::to('/') }}/assets/templated-spatial/images/acheteur.jpg" alt="" /></div>
								<div class="content">
									<header>
										<h4>Acheteurs</h4>
										<p>Acheteurs, marketeurs</p>
									</header>
									<p>Négociation directe des prix des productions avec les agriculteurs ; publicité pour agriculteurs</p>
								</div>
							</div>
							<div class="feature">
								<div class="image rounded"><img src="{{ URL::to('/') }}/assets/templated-spatial/images/statistique.jpg" alt="" /></div>
								<div class="content">
									<header>
										<h4>Pouvoirs publics</h4>
										<p>Ministères, Instituts, laboratoires, </p>
									</header>
									<p>Envoie de messages d'alertes aux agriculteurs. Statistiques globales sur le rendement de la production</p>
								</div>
							</div>
						</div>
					</div>
				</section>

			<!-- Four -->
				<section id="four" class="wrapper style3 special">
					<div class="container">
						<header class="major">
							<h2>Accès à la plateforme</h2>
							<p>L'accès à la plateforme est <b>gratuite</b> pour les agriculteurs. Les autres types d'acteurs doivent nous contacter pour avoir un identifiant leur permettant d'utiliser les fonctionnalités offertes par Agritech.</p>
						</header>
						<ul class="actions">
							<li><a href="{{ URL::to('/login') }}" class="button special big">Vous connecter</a>
							<a href="{{ URL::to('/register') }}" class="button special big">Nous rejoindre !</a></li>
						</ul>
					</div>
				</section>

		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="#" class="icon fa-facebook"></a></li>
						<li><a href="#" class="icon fa-twitter"></a></li>
						<li><a href="#" class="icon fa-instagram"></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy; Agritech 2015</li>
						<li><a href="mailto:defolandry@yahoo.fr">Nous contacter</a></li>
					</ul>
				</div>
			</footer>

	</body>
</html>