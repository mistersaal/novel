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

        }).then(() => {
            this.loading = false
            this.$store.commit('userDataLoaded')
        })
    },
    mounted() {
        if (this.findGetParameter('resetPassword')) {
            const email = this.findGetParameter('email')
            const token = this.findGetParameter('token')
            window.history.replaceState({}, document.title, "/#/");
            this.$router.push({
                name: 'NewPassword',
                params: {
                    email: email,
                    token: token
                }
            })
        }
    },
    methods: {
        findGetParameter(parameterName) {
            var result = null,
                tmp = [];
            location.search
                .substr(1)
                .split("&")
                .forEach(function (item) {
                    tmp = item.split("=");
                    if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                });
            return result;
        }
    }
}
</script>
