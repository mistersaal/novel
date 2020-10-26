<template>
    <div>
        <navbar></navbar>
        <section class="section">
            <div class="columns is-centered">
                <div class="column is-one-third">
                    <h1 class="title">Подтверждение почты</h1>
                    <div class="box">
                        <p class="mb-2">Вам отправлено письмо на почту с ссылкой для подтверждения.</p>
                        <b-field>
                            <b-button @click="resend" :loading="resending">Отправить повторно</b-button>
                        </b-field>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar'

export default {
    name: "Verify",
    components: {Navbar},
    data() {
        return {
            resending: false,
        }
    },
    methods: {
        resend() {
            this.resending = true
            axios.post('/email/resend').then(() => this.resending = false)
                .catch((error) => {
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
