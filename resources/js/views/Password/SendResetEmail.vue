<template>
    <div>
        <navbar></navbar>
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-one-third">
                    <h1 class="title">Восстановить пароль</h1>
                    <form class="box" @submit.prevent="reset" v-if="!sent">
                        <b-field label="E-mail">
                            <b-input type="email" v-model="data.email" placeholder="example@mail.ru" required></b-input>
                        </b-field>
                        <b-field>
                            <b-button expanded type="is-info" native-type="submit" :loading="loading">Восстановить пароль</b-button>
                        </b-field>
                        <p class="help is-danger" v-if="message !== ''">{{ message }}</p>
                    </form>
                    <div class="box" v-else>
                        <p>Ссылка на сброс пароля была отправлена на почту.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar'
export default {
    name: "SendResetEmail",
    components: {Navbar},
    data() {
        return {
            data: {
                email: ''
            },
            loading: false,
            message: '',
            sent: false,
        }
    },
    methods: {
        reset() {
            this.loading = true
            this.message = ''
            axios.post('/password/email', this.data).then((response) => {
                this.sent = true
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
        }
    }
}
</script>

<style scoped>

</style>
