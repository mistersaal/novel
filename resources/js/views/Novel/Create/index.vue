<template>
    <div>
        <navbar></navbar>
        <header class="hero is-light">
            <div class="hero-body">
                <div class="container">
                    <div class="title">
                        Начало создания новеллы
                    </div>
                    <div class="subtitle">
                        Маленький, но важный шаг на пути создания своего произведения
                    </div>
                </div>
            </div>
        </header>
        <section class="section">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-half">
                        <h2 class="title is-4">Заполните поля</h2>
                        <form @submit.prevent="createNovel" class="box">
                            <b-field label="Название" ref="name">
                                <b-input has-counter
                                         maxlength="50"
                                         required
                                         v-model="novel.name"
                                ></b-input>
                            </b-field>
                            <b-field label="Описание" ref="description">
                                <b-input type="textarea"
                                         has-counter
                                         maxlength="1000"
                                         required
                                         v-model="novel.description"
                                ></b-input>
                            </b-field>
                            <b-field grouped>
                                <div class="control">
                                    <b-button type="is-primary"
                                              native-type="submit"
                                              :loading="loading"
                                    >Создать</b-button>
                                </div>
                                <div class="control">
                                    <b-button type="is-light"
                                              tag="router-link"
                                              :to="{name: 'Home'}"
                                    >Отмена</b-button>
                                </div>
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
    name: "NovelCreate",
    components: {Navbar},
    data() {
        return {
            novel: {
                name: '',
                description: '',
            },
            loading: false,
        }
    },
    methods: {
        createNovel() {
            this.loading = true
            axios.post('/api/novels', this.novel)
                .then(({data}) => {
                    this.$store.commit('addUserNovel', data.novel)
                    this.$router.push({name: 'NovelEdit', params: {id: data.novel.id}})
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
        },
    },
}
</script>

<style scoped>

</style>
