<?=B::nav(B::ul(
	B::li(B::a(
		array('href' => SITE_URL),
		'Dashboard'
	)),
	B::li(B::a(
		array('href' => SITE_URL . 'pages'),
		'Pages'
	)),
	B::li(B::a(
		array('href' => SITE_URL . 'users'),
		'Users'
	)),
	B::li(B::a(
		array('href' => SITE_URL . 'sandbox'),
		'Sandbox'
	)),
	B::li(B::a(
		array('href' => SITE_URL . 'logout'),
		'Logout'
	))
));