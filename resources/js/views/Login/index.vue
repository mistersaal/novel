<template>
    <div>
        <navbar></navbar>
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-one-third">
                    <h1 class="title">Вход</h1>
                    <form class="box" @submit.prevent="login">
                        <b-field label="E-mail">
                            <b-input type="email" v-model="data.email" placeholder="example@mail.ru" required></b-input>
                        </b-field>
                        <b-field label="Пароль">
                            <b-input type="password" v-model="data.password" required></b-input>
                        </b-field>
                        <b-field>
                            <b-checkbox v-model="data.remember">Запомнить</b-checkbox>
                        </b-field>
                        <b-field>
                            <b-button expanded type="is-info" native-type="submit" :loading="loading">Войти</b-button>
                        </b-field>
                        <p class="help is-danger" v-if="message !== ''">{{ message }}</p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar'
export default {
    name: "Login",
    components: {Navbar},
    data() {
        return {
            data: {
                email: '',
                password: '',
                remember: false,
            },
            message: '',
            loading: false,
        }
    },
    methods: {
        login() {
            this.message = ''
            this.loading = true
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/login', this.data).then(() => {
                    axios.get('/api/user').then(({data}) => {
                        this.$store.commit('setUser', data.user)
                        this.$router.push({name: 'Home'})
                    })
                }).catch((error) => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            this.message = error.response.data.errors.email[0]
                            this.loading = false
                            return
                        }
                    }
                    this.$buefy.notification.open({
                        message: 'Неизвестная ошибка',
                        duration: 10000,
                        type: 'is-danger'
                    })
                    this.loading = false
                })
            })
        },
    }
}
</script>

<style scoped>

</style>
