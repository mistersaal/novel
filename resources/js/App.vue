<template>
    <div>
        <b-loading :active="loading" is-full-page></b-loading>
        <router-view v-if="!loading"/>
    </div>
</template>
<script>
    export default {
        name: 'App',
        computed: {},
        data() {
            return {
                loading: true,
            }
        },
        created() {
            axios.get('/api/user').then(({data}) => {
                this.$store.commit('setUser', data.user)
            }).catch((error) => {

            }).then(() => this.loading = false)
        }
    }
</script>
