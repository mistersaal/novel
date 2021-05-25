<template>
    <div>
        <navbar></navbar>
        <b-loading :active="!novelLoaded" is-full-page></b-loading>
        <template v-if="novelLoaded">
            <div class="description">
                <section class="section">
                    <div class="container pl-5 pr-5">
                        <h1 class="title is-2 is-spaced">
                            {{ novel.name }}
                            <template v-if="novel.is_banned">
                                <br>❌
                            </template>
                        </h1>
                        <p class="subtitle">{{ novel.description }}</p>
                        <p class="subtitle has-text-grey">
                            @{{ novel.author.name }}
                            <template v-if="novel.author.is_banned">
                                <br>❌
                            </template>
                        </p>
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

                        <template v-if="$store.state.user.is_admin">
                            <b-field v-if="!novel.is_banned">
                                <b-button size="is-normal"
                                          type="is-danger"
                                          expanded
                                          @click="blockNovel"
                                >Заблокировать новеллу</b-button>
                            </b-field>
                            <b-field v-else>
                                <b-button size="is-normal"
                                          type="is-danger"
                                          expanded
                                          @click="unblockNovel"
                                >Разблокировать новеллу</b-button>
                            </b-field>

                            <b-field v-if="!novel.author.is_banned">
                                <b-button size="is-normal"
                                          type="is-danger"
                                          expanded
                                          @click="blockUser"
                                >Заблокировать пользователя</b-button>
                            </b-field>
                            <b-field v-else>
                                <b-button size="is-normal"
                                          type="is-danger"
                                          expanded
                                          @click="unblockUser"
                                >Разблокировать пользователя</b-button>
                            </b-field>
                        </template>
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
                    name: "",
                    is_banned: false,
                },
                name: "",
                description: "",
                first_scene_id: 0,
                cover: null,
                is_banned: false,
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
        this.loadPageData()
    },
    methods: {
        blockUser() {
            this.novelLoaded = false
            axios.post('/api/admin/block/user/' + this.novel.id).then(() => {
                this.loadPageData()
            })
        },
        unblockUser() {
            this.novelLoaded = false
            axios.post('/api/admin/unblock/user/' + this.novel.id).then(() => {
                this.loadPageData()
            })
        },
        blockNovel() {
            this.novelLoaded = false
            axios.post('/api/admin/block/novel/' + this.novel.author.id).then(() => {
                this.loadPageData()
            })
        },
        unblockNovel() {
            this.novelLoaded = false
            axios.post('/api/admin/unblock/novel/' + this.novel.author.id).then(() => {
                this.loadPageData()
            })
        },
        loadPageData() {
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
        }
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
@media (max-width: 768px) {
    .description {
        top: 300px;
        padding-top: 0;
        height: auto;
    }
    .cover {
        width: 100%;
        height: 300px;
    }
}
</style>
