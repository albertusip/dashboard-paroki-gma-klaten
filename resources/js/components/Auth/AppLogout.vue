<template>
  
</template>
<script>
export default {
    async created(){
        try {
            let res = await this.$user.logout();
            this.$user.clearStorage();
            this.$router.replace('/login');
        } catch (err) {
            console.log(err);
        }
    },
}
</script>
