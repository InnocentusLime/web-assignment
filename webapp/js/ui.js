const popup = Notification({
	position: 'bottom-right',
	duration: 4000,
	isHidePrev: false,
	isHideTitle: false,
	maxOpened: 3,
});

async function place_order(x) {
	console.log("place order at address " + x);

	const response = await fetch("/api/place_order.php?delivery_address=" + x);
	const data = await response.json();
	console.log(data);

	if (data.status == "ok") {
		let order_id = data.data.order_id;
		window.location.replace("/order_page.php?order_id=" + order_id);
	}
}

async function add_to_cart(x) {
    // do request to /api/add_to_cart.php?item_id=x
    console.log("Add to cart", x);
	const response = await fetch("/api/add_to_cart.php?item_id=" + x);
	const data = await response.json();
	console.log(data);

	if (data.status == "ok") {
		popup.info({
			title: 'Success',
			message: 'The product has been added to your cart!'
		})
	}
}

function go_to_order_page(x) {
	window.location.href = "/order_page.php?order_id=" + x;
}

async function logout() {
	console.log("Logout");
	const response = await fetch("/api/logout.php");
	const data = await response.json();
	console.log(data);

	if (data.status == "ok") {
		window.location.replace("/auth.php");
	}
}

async function remove_from_cart(x) {
	// do request to /api/remove_to_cart.php?item_id=x
	console.log("Remove from cart", x);
	const response = await fetch("/api/remove_from_cart.php?item_id=" + x);
	const data = await response.json();
	console.log(data);
	window.location.reload();
}

async function do_login(event) {
	event.preventDefault();
	console.log("Login");
	const new_user = 0;
	const login = document.getElementById("login").value;
	const password = document.getElementById("passwd").value;
	const response = await fetch("/api/auth.php?new=" + new_user + "&login=" + login + "&passwd=" + password);
	const data = await response.json();
	console.log(data);

	if (data.status == "ok") {
		window.location.replace("/account.php");
	}

	if (data.status == "err") {
		popup.error({
			title: 'Login error',
			message: data.code,
		})
	}
}

async function do_register(event) {
	event.preventDefault();
	console.log("Register");
	const new_user = 1;
	const login = document.getElementById("login").value;
	const password = document.getElementById("passwd").value;
	const response = await fetch("/api/auth.php?new=" + new_user + "&login=" + login + "&passwd=" + password);
	const data = await response.json();
	console.log(data);

	if (data.status == "ok") {
		window.location.replace("/account.php");
	}

	if (data.status == "err") {
		popup.error({
			title: 'Register error',
			message: data.code,
		})
	}
}