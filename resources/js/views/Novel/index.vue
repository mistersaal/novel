<template>
    <div>
        <navbar></navbar>
        <b-loading :active="!novelLoaded" is-full-page></b-loading>
        <template v-if="novelLoaded">
            <div class="description">
                <section class="section">
                    <div class="container pl-5 pr-5">
                        <h1 class="title is-2 is-spaced">{{ novel.name }}</h1>
                        <p class="subtitle">{{ novel.description }}</p>
                        <b-field v-if="novel.first_scene_id">
                            <b-button size="is-medium"
                                      type="is-primary"
                                      expanded
                                      tag="router-link"
                                      :to="playLink"
                            >Играть</b-button>
                        </b-field>
                        <p class="has-text-danger mb-5" v-else>Новелла в процессе разработки!</p>

                        <b-field v-if="userIsAuthor">
                            <b-button size="is-medium"
                                      expanded
                                      tag="router-link"
                                      :to="editLink"
                            >Редактировать</b-button>
                        </b-field>
                    </div>
                </section>
            </div>
            <div class="cover" :style="novel.cover ? {'background-image': 'url(' + novel.cover.path + ')'} : {}"></div>
        </template>
    </div>
</template>

<script>
import Navbar from '../../components/Navbar'
export default {
    name: "Novel",
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
        playLink() {
            return this.$store.state.user ? {name: 'NovelProcess', params: {id: this.novel.id}} : {name: 'Login'}
        },
        editLink() {
            return this.$store.state.user ? {name: 'NovelEdit', params: {id: this.novel.id}} : {name: 'Login'}
        }
    },
    created() {
        axios.get(this.novelPath).then(({data}) => {
            this.novel = data.novel
            this.novelLoaded = true
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

<style scoped lang="scss">
.description {
    position: absolute;
    top: 0;
    left: 0;
    padding-top: 64px;
    height: 100%;
    width: 100%;
    max-width: 500px;
    background-color: white;
}
.cover {
    position: absolute;
    top: 0;
    right: 0;
    padding-top: 64px;
    height: 100%;
    width: calc(100% - 500px);
    background-position: center;
    background-size: cover;
    background-color: lightgray;
    z-index: -1;
}
</style>
