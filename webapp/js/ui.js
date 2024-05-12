function add_to_cart(x) {
    // do request to /api/add_to_cart.php?item_id=x
    console.log("Add to cart", x);
}

async function logout() {
	console.log("Logout");
	const response = await fetch("/api/logout.php");
	const todos = await response.json();
	console.log(todos);
}

function remove_from_cart(x) {
	console.log("Remove from cart", x);
}

function do_login(event) {
	event.preventDefault();
	console.log("Login");
}

function do_register(event) {
	event.preventDefault();
	console.log("Register")
}