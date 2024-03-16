export function isAuthenticated() {
    const token = sessionStorage.getItem('url_shortener_token');
    return !!token;
  }
