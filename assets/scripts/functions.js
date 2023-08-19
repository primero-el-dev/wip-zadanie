export function setLoggedUser(user) {
	window.localStorage.setItem('current-user', JSON.stringify(user));
}

export function isUserLogged() {
	let sessionExpiry = getCookie('SESSION-EXPIRY');
	
	return sessionExpiry >= new Date().getTime() / 1000;
}

export function logout() {
	window.localStorage.removeItem('current-user');
}

export function getLoggedUserRoles() {
	let userData = window.localStorage.getItem('current-user');

	return userData ? JSON.parse(userData).roles : [];
}

export function isLoggedUserAndHasRole(role) {
	return isUserLogged() && getLoggedUserRoles().filter(r => r === role).length > 0;
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) {
  	return parts.pop().split(';').shift();
  }
}