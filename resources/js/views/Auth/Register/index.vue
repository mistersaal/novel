<template>
    <div>
        <navbar></navbar>
        <section class="section">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-one-third">
                        <h1 class="title">Регистрация</h1>
                        <form class="box" @submit.prevent="register">
                            <b-field label="E-mail" ref="email">
                                <b-input type="email" v-model="data.email" placeholder="example@mail.ru" required></b-input>
                            </b-field>
                            <b-field label="Никнейм" ref="name">
                                <b-input type="text" v-model="data.name" placeholder="user123" maxlength="255" required :has-counter="false"></b-input>
                            </b-field>
                            <b-field label="Пароль" ref="password">
                                <b-input type="password" v-model="data.password" required></b-input>
                            </b-field>
                            <b-field label="Повторите пароль" ref="password_confirmation">
                                <b-input type="password" v-model="data.password_confirmation" required></b-input>
                            </b-field>
                            <b-field>
                                <b-button expanded type="is-info" native-type="submit" :loading="loading">Зарегистрироваться</b-button>
                            </b-field>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Navbar from '../../../components/Navbar'
export default {
    name: "Register",
    components: {Navbar},
    data() {
        return {
            data: {
                email: '',
                name: '',
                password: '',
                password_confirmation: '',
            },
            loading: false,
        }
    },
    methods: {
        register() {
            this.loading = true
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/register', this.data).then(() => {
                    axios.get('/api/user').then(({data}) => {
                        this.$store.commit('setUser', data.user)
                        this.$router.push({name: 'VerifyEmail'})
                    })
                }).catch((error) => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            this.loading = false
                            const errors = error.response.data.errors
                            Object.keys(errors).forEach((key) => {
                                this.$refs[key].newMessage = errors[key][0]
                                this.$refs[key].newType = 'is-danger'
                            })
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
