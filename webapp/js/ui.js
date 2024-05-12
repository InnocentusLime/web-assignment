async function add_to_cart(x) {
    // do request to /api/add_to_cart.php?item_id=x
    console.log("Add to cart", x);
	const response = await fetch("/api/add_to_cart.php?item_id=" + x);
	const todos = await response.json();
	console.log(todos);

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
	const todos = await response.json();
	console.log(todos);
}

async function do_login(event) {
	event.preventDefault();
	console.log("Login");
	const new_user = 0;
	const login = document.getElementById("login").value;
	const password = document.getElementById("passwd").value;
	const response = await fetch("/api/auth.php?new=" + new_user + "&login=" + login + "&passwd=" + password);
	const todos = await response.json();
	console.log(todos);
}

async function do_register(event) {
	event.preventDefault();
	console.log("Register");
	const new_user = 1;
	const login = document.getElementById("login").value;
	const password = document.getElementById("passwd").value;
	const response = await fetch("/api/auth.php?new=" + new_user + "&login=" + login + "&passwd=" + password);
	const todos = await response.json();
	console.log(todos);
}