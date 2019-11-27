<template>
    <v-app>
        <router-view></router-view>
        <v-dialog
            v-model="dialogInternalErr"
            max-width="500" persistent
        >
            <dialog-system-error @close="dialogInternalErr = false" persistent></dialog-system-error>
        </v-dialog>

        <v-dialog
            v-model="dialogLoginErr"
            max-width="500" persistent
        >
            <dialog-login-error @close="dialogLoginErr = false"></dialog-login-error>
        </v-dialog>

        <v-dialog
            v-model="dialogNotFoundError"
            max-width="500" persistent
        >
            <dialog-not-found-error @close="dialogNotFoundError = false"></dialog-not-found-error>
        </v-dialog>
    </v-app>
</template>

<script>
import DialogSystemError from './ErrorDialogs/DialogSystemError'
import DialogLoginError from './ErrorDialogs/DialogLoginError'
import DialogNotFoundError from './ErrorDialogs/DialogNotFoundError'

export default {
    components: {
        DialogSystemError,
        DialogLoginError,
        DialogNotFoundError,
    },
    data: () => ({  
        dialogInternalErr: false,
        dialogLoginErr: false,
        dialogNotFoundError: false,
    }),
    mounted() {
        EventBus.$on('internal_error', () => {
            this.dialogInternalErr = true
        })

        EventBus.$on('notlogin_error', () => {
            this.dialogLoginErr = true
        })

        EventBus.$on('notfound_error', () => {
            this.dialogNotFoundError = true
        })
    },
}
</script>
<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:100,300,400,500,700,900');

    div.swal-modal {
        font-family: 'Montserrat', sans-serif !important;
    }

    :not(i) {
        font-family: 'Montserrat', sans-serif !important;
    }

    button {
        outline: none;
    }
    
    .v-btn {
        outline: none;
    }
</style>