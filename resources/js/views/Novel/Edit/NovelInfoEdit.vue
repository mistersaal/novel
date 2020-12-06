<template>
    <section class="section">
        <div class="container">
            <form @submit.prevent="update">
                <b-field label="Название" ref="name">
                    <b-input v-model="localNovel.name"></b-input>
                </b-field>
                <b-field label="Описание" ref="description">
                    <b-input type="textarea" v-model="localNovel.description"></b-input>
                </b-field>
                <label class="label">Обложка</label>
                <b-field class="file" :class="{'has-name': !!localNovel.image_id}" @click="choosingImage = true">
                    <div class="file-label" @click="choosingImage = true">
                        <span class="file-cta">
                            <span class="file-label">{{ !!localNovel.image_id ? 'Изменить' : 'Выбрать' }} обложку</span>
                        </span>
                        <span class="file-name" v-if="localNovel.image_id">
                            {{ images[localNovel.image_id] ? images[localNovel.image_id].name : '' }}
                        </span>
                    </div>
                </b-field>
                <select-image :active.sync="choosingImage"
                              :images="images"
                              @image="setImage($event)"
                              :novel="novel"
                              :novel-path="novelPath"
                ></select-image>
                <b-field>
                    <b-button type="is-primary"
                              :disabled="!changed"
                              native-type="submit"
                              :loading="loading"
                    >Сохранить</b-button>
                </b-field>
            </form>
        </div>
    </section>
</template>

<script>
import SelectImage from "./SelectImage"
export default {
    name: "NovelInfoEdit",
    props: ["novel", "novelPath", "images"],
    components: {SelectImage},
    data() {
        return {
            localNovel: {
                name: '',
                description: '',
                cover: 0,
            },
            loading: false,
            choosingImage: false,
        }
    },
    watch: {
        novel(value) {
            this.setupLocalNovel(value)
        }
    },
    computed: {
        changed() {
            return !_.isEqual(this.localNovel, this.novel)
        }
    },
    created() {
        this.setupLocalNovel(this.novel)
    },
    methods: {
        setupLocalNovel(value) {
            this.localNovel = _.clone(value)
            if (this.localNovel.cover === null) {
                this.localNovel.image_id = null
            } else {
                this.localNovel.image_id = this.localNovel.cover.id
            }
        },
        setImage(image_id) {
            this.localNovel.image_id = image_id
        },
        update() {
            if (!this.changed) {
                return
            }
            this.loading = true
            let data = {}
            if (this.novel.name !== this.localNovel.name) {
                data.name = this.localNovel.name
            }
            if (this.novel.description !== this.localNovel.description) {
                data.description = this.localNovel.description
            }
            if (this.novel.cover !== null && this.novel.cover.id !== this.localNovel.image_id ||
                this.novel.cover === null && this.localNovel.image_id !== null
            ) {
                data.image_id = this.localNovel.image_id
            }
            axios.patch(this.novelPath, data).then(({data}) => {
                this.$emit("update:novel", data.novel)
                this.$store.commit("updateNovel", data.novel)
                this.$buefy.notification.open({
                    type: 'is-success',
                    duration: 2000,
                    message: 'Описание обновлено'
                })
                this.loading = false
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
        }
    }
}
</script>

<style scoped>

</style>
