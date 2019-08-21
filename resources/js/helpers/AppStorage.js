class AppStorage {
    storeToken(token) {
        localStorage.setItem('token-gma', token);
    }

    storeUser(user) {
        localStorage.setItem('user-gma', user);
    }

    store(user, token) {
        this.storeToken(token);
        this.storeUser(user);
    }

    clear() {
        localStorage.removeItem('token-gma');
        localStorage.removeItem('user-gma');
    }

    getToken() {
        return localStorage.getItem('token-gma');
    }
    getUser() {
        let user = localStorage.getItem('user-gma');
        return JSON.parse(user)
    }
}
export default AppStorage = new AppStorage();