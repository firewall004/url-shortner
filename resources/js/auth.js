const AUTH_TOKEN_ID = 'url_shortener_token';

export function isAuthenticated() {
    const token = sessionStorage.getItem(AUTH_TOKEN_ID);
    return !!token;
}

export function getAuthToken() {
    return sessionStorage.getItem(AUTH_TOKEN_ID);
}

export function setAuthToken(token) {
    sessionStorage.setItem(AUTH_TOKEN_ID, token);
}

export function removeAuthToken(token) {
    sessionStorage.removeItem(AUTH_TOKEN_ID);
}
