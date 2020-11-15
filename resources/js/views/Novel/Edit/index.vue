<template>
    <div>
        <navbar></navbar>
        <b-loading :active="!novelLoaded"></b-loading>
        <section v-if="novelLoaded" class="hero is-light">
            <div class="hero-body">
                <div class="container">
                    <div class="title">{{ novel.name }}</div>
                    <div class="subtitle">Редактирование новеллы</div>
                </div>
            </div>
            <div class="hero-foot">
                <div class="tabs is-boxed is-fullwidth">
                    <div class="container">
                        <ul>
                            <router-link tag="li" active-class="is-active" exact :to="{name: 'NovelEdit', params: {id: id}}">
                                <a>Описание</a>
                            </router-link>
                            <router-link tag="li" active-class="is-active" exact :to="{name: 'ScenesEdit', params: {id: id}}">
                                <a>Сцены</a>
                            </router-link>
                            <router-link tag="li" active-class="is-active" exact :to="{name: 'NovelImages', params: {id: id}}">
                                <a>Изображения</a>
                            </router-link>
                            <router-link tag="li" active-class="is-active" exact :to="{name: 'NovelMusics', params: {id: id}}">
                                <a>Музыка</a>
                            </router-link>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <router-view :novel.sync="novel" :novel-path="novelPath"></router-view>
    </div>
</template>

<script>
import Navbar from '../../../components/Navbar'
export default {
    name: "NovelEdit",
    components: {Navbar},
    data() {
        return {
            novel: {
                id: 0,
                author: {
                    id: 0,
                    name: ""
                },
                name: "",
                description: "",
                first_scene_id: 0,
                cover: null
            },
            novelLoaded: false,
        }
    },
    computed: {
        id() {
            return this.$route.params['id']
        },
        novelPath() {
            return '/api/novels/' + this.id
        },
        userIsAuthor() {
            return this.$store.state.user && this.novel.author.id === this.$store.state.user.id
        },
    },
    created() {
        axios.get(this.novelPath).then(({data}) => {
            this.novel = data.novel
            this.novelLoaded = true
            if (!this.userIsAuthor) {
                this.$router.replace({name: 'Home'})
            }
        }).catch((error) => {
            if (error.response) {
                if (error.response.status === 404) {
                    this.$buefy.notification.open({
                        message: 'Такой новеллы не существует',
                        duration: 3000,
                        type: 'is-danger',
                    })
                    this.$router.replace({name: 'Home'})
                    return
                }
            }
            throw error
        }).catch(defaultErrorHandler)
    },
}
</script>

<style scoped>

</style>
