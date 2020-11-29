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
                <b-field label="Обложка">
                    <b-select placeholder="Выберите изображение" v-model="localNovel.image_id" expanded>
                        <option
                            v-for="image in images"
                            :value="image.id"
                            :key="image.id"
                        >
                            {{ image.name }}
                        </option>
                    </b-select>
                </b-field>
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
export default {
    name: "NovelInfoEdit",
    props: ["novel", "novelPath"],
    data() {
        return {
            localNovel: {
                name: '',
                description: '',
                cover: 0,
            },
            images: [],
            loading: false,
        }
    },
    watch: {
        novel(value) {
            this.localNovel = _.clone(value)
            this.localNovel.image_id = this.localNovel.cover.id
        }
    },
    computed: {
        changed() {
            return !_.isEqual(this.localNovel, this.novel)
        }
    },
    created() {
        this.localNovel = _.clone(this.novel)
        axios.get(this.novelPath + '/images')
            .then(({data}) => this.images = data.data)
            .catch(defaultErrorHandler)
    },
    methods: {
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
            if (this.novel.cover.id !== this.localNovel.image_id) {
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
