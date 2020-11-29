<template>
    <section class="section">
        <div class="container">
            <b-loading :active="!loaded" :is-full-page="false"></b-loading>
            <div class="columns">
                <div class="column is-one-quarter">
                    <div class="box">
                        <b-button expanded type="is-primary" @click="openLoadForm">Загрузить</b-button>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-one-quarter" v-for="(image, key) in images" :key="key">
                    <div class="box is-clickable">
                        <figure class="image">
                            <img :src="image.path">
                        </figure>
                        <p class="title mt-2 is-6">{{ image.name }}</p>
                    </div>
                </div>
            </div>
            <b-modal :active.sync="loadForm" has-modal-card>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Новое изображение</p>
                    </header>
                    <form @submit.prevent="loadNew">
                        <div class="modal-card-body">
                            <b-field class="file is-primary" :class="{'has-name': !!image.file}">
                                <b-upload v-model="image.file" class="file-label" expanded>
                                <span class="file-cta">
                                    <span class="file-label">Выбрать файл</span>
                                </span>
                                    <span class="file-name" v-if="image.file">
                                    {{ image.file.name }}
                                </span>
                                </b-upload>
                            </b-field>

                            <b-field label="Имя изображения">
                                <b-input
                                    type="text"
                                    v-model="image.name"
                                    placeholder="Имя изображения"
                                    required>
                                </b-input>
                            </b-field>
                        </div>
                        <footer class="modal-card-foot">
                            <b-button native-type="button" @click="loadForm = false">Отмена</b-button>
                            <b-button native-type="submit" type="is-primary" :loading="formLoading">Сохранить</b-button>
                        </footer>
                    </form>
                </div>
            </b-modal>
        </div>
    </section>
</template>

<script>
export default {
    name: "Images",
    props: ['novel', 'novelPath'],
    data() {
        return {
            images: [],
            image: {
                file: null,
                name: '',
            },
            loaded: false,
            loadForm: false,
            formLoading: false,
        };
    },
    created() {
        axios.get(this.novelPath + '/images')
            .then(({data}) => {
                this.images = data.data
                this.loaded = true
            }).catch(defaultErrorHandler)
    },
    methods: {
        openLoadForm() {
            this.loadForm = true
        },
        loadNew() {
            this.formLoading = true
            let formData = new FormData()
            formData.append('name', this.image.name)
            formData.append('file', this.image.file)
            axios.post(this.novelPath + '/images',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(({data}) => {
                    this.images.push(data.image)
                    this.formLoading = false
                    this.loadForm = false
                })
                .catch((error) => {
                    this.formLoading = false
                    throw error
                })
                .catch(defaultErrorHandler)
        }
    }
}
</script>

<style scoped>

</style>
