<template>
    <div>
        <navbar></navbar>
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-one-third">
                    <h1 class="title">Новый пароль</h1>
                    <form class="box" @submit.prevent="reset">
                        <b-field label="Пароль" ref="password">
                            <b-input type="password" v-model="password" required></b-input>
                        </b-field>
                        <b-field label="Повторите пароль" ref="password_confirmation">
                            <b-input type="password" v-model="password_confirmation" required></b-input>
                        </b-field>
                        <b-field>
                            <b-button expanded type="is-info" native-type="submit" :loading="loading">
                                Сохранить
                            </b-button>
                        </b-field>
                        <p class="help is-danger" v-if="message !== ''">{{ message }}</p>
                    </form>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Navbar from "../../components/Navbar";

export default {
    name: "NewPassword",
    components: {Navbar},
    data() {
        return {
            password: '',
            password_confirmation: '',
            loading: false,
            message: '',
        }
    },
    methods: {
        reset() {
            this.message = ''
            this.loading = true
            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/password/reset', {
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    email: this.$route.params['email'],
                    token: this.$route.params['token'],
                }).then(() => {
                    axios.get('/api/user').then(({data}) => {
                        this.$store.commit('setUser', data.user)
                        this.$router.push({name: 'Home'})
                    })
                }).catch((error) => {
                    if (error.response) {
                        if (error.response.status === 422) {
                            this.loading = false
                            this.message = error.response.data.errors.password[0]
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
