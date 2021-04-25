<template>
    <div>
        <navbar></navbar>
        <section class="hero">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        Конструктор визуальных новелл
                    </h1>
                    <h2 class="subtitle">
                        Создай свою собственную новеллу или сыграй в уже созданные!
                    </h2>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="box">
                    <h3 class="title is-5">Воплоти сюжет их своей головы в реальность</h3>
                    <b-button size="is-medium"
                              expanded
                              type="is-primary"
                              tag="router-link"
                              :to="$store.state.user ? {name: 'NovelCreate'} : {name: 'Login'}"
                    >Создать новеллу</b-button>
                </div>
                <div class="box" v-if="ownNovels.length">
                    <h3 class="title is-5">Свои новеллы</h3>
                    <div class="has-text-grey-light has-text-centered">
                        <div class="columns is-multiline">
                            <div class="column is-one-quarter" v-for="ownNovel in ownNovels" :key="ownNovel.id">
                                <novel-card :novel="ownNovel" user-is-author></novel-card>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box container" ref="allNovels">
                    <h3 class="title is-5">Пользовательские новеллы</h3>
                    <div class="has-text-grey-light has-text-centered">
                        <p v-if="allNovels.length === 0">Пока что тут ничего нет...</p>
                        <div v-else class="columns is-multiline">
                            <div class="column is-one-quarter" v-for="novel in allNovels" :key="novel.id">
                                <novel-card :novel="novel"></novel-card>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <site-footer></site-footer>
    </div>
</template>

<script>
    import Navbar from "../../components/Navbar"
    import SiteFooter from "../../components/SiteFooter"
    import NovelCard from "./NovelCard";
    export default {
        name: 'Home',
        components: {NovelCard, SiteFooter, Footer: SiteFooter, Navbar},
        data() {
            return {
                allNovels: [],
            }
        },
        methods: {

        },
        computed: {
            ownNovels() {
                return this.$store.state.user ? this.$store.state.user.novels : []
            },
        },
        watch: {

        },
        mounted() {
            const loading = this.$buefy.loading.open({
                container: this.$refs.allNovels
            })
            axios.get('/api/novels').then(({data}) => {
                this.allNovels = data.data;
                loading.close()
            }).catch(defaultErrorHandler)
        }
    }
</script>

<style scoped>

</style>
