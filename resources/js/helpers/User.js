import AppStorage from './AppStorage'

class User {
    login(data) {
        return axios.post('/api/auth/login', data, {
            headers: {
                'Accept': 'application/json',
                'Content-type': 'application/json',
            }
        })
    }

    storeSession(data) {
        return new Promise((resolve, reject) => {
            const user = JSON.stringify(data.user)
            
            const token = data.access_token
            AppStorage.store(user, token)
            resolve()
        })
    }

    loggedIn() {
        const storedToken = AppStorage.getToken();
        if (!!storedToken)
            return true
        else
            return false
    }

    getToken() {
        const storedToken = AppStorage.getToken();
        return storedToken
    }

    logout() {
        return axios.post('/api/auth/logout', {
            token: AppStorage.getToken(),
        }, {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            });
    }

    clearStorage() {
        AppStorage.clear();
    }

    info() {
        if (this.loggedIn) {
            return AppStorage.getUser()
        }
        return console.log("please login first")
    }

    // updateInfo() {
    //     return new Promise((resolve, reject) => {
    //         if (this.loggedIn) {
    //             axios.get('/api/user', {
    //                 params: {
    //                     token: AppStorage.getToken(),
    //                 }
    //             }, {
    //                     headers: {
    //                         'Accept': 'application/json',
    //                         'Content-type': 'application/json'
    //                     }
    //                 }).then(response => {
    //                     if (response.data.error == false) {
    //                         AppStorage.storeUser(JSON.stringify(response.data.item))
    //                         resolve("update success")
    //                     } else {
    //                         reject("User update went wrong")
    //                     }
    //                 }).catch(err => {
    //                     reject(err)
    //                 })
    //         } else {
    //             reject("notloggedin")
    //         }
    //     })
    // }
}

export default User = new User();
