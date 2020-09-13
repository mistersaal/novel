<template>
    <div>
        <navbar></navbar>
        <section class="hero">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title">
                        LOS COPS PLAYABLE TEASER
                    </h1>
                    <h2 class="subtitle">
                        Сыграй в наш тизер визуальной новеллы LOS COPS и попробуй создать новеллу со свой историей!
                    </h2>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column">
                        <div class="box">
                            <h3 class="title is-5">Los Cops</h3>
                            <b-button size="is-medium" expanded type="is-danger">Играть</b-button>
                        </div>
                    </div>
                    <div class="column">
                        <div class="box">
                            <h3 class="title is-5">Создать свою новеллу</h3>
                            <b-button size="is-medium" expanded type="is-primary">Создать</b-button>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <h3 class="title is-5">Пользовательские новеллы</h3>
                    <div class="has-text-grey-light has-text-centered">
                        <p>Пока что тут ничего нет...</p>
                    </div>
                </div>
            </div>
        </section>
        <site-footer></site-footer>
    </div>
</template>

<script>
    import Navbar from "../components/Navbar"
    import SiteFooter from "../components/SiteFooter"
    export default {
        name: 'Home',
        components: {SiteFooter, Footer: SiteFooter, Navbar},
        data() {
            return {

            }
        },
        methods: {

        },
        computed: {

        },
        watch: {

        },
        created() {

        }
    }
</script>

<style scoped>

</style>
