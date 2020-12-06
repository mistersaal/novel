<template>
    <div>
        <images :novel="novel" :novel-path="novelPath" :images="images" @image="openEditor($event)"></images>
        <b-modal :active="editorOpened" :can-cancel="['escape', 'outside']" @close="editorOpened = false">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">Выбрать изображение</p>
                    <button
                        type="button"
                        class="delete"
                        @click="editorOpened = false"/>
                </header>
                <section class="modal-card-body">
                    <div class="columns">
                        <div class="column">
                            <figure v-if="image_id !== null">
                                <img :src="image.path">
                            </figure>
                        </div>
                        <div class="column">
                            <b-field label="Имя изображения">
                                <b-input v-model="localImage.name"></b-input>
                            </b-field>
                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <b-button @click="editorOpened = false">Отмена</b-button>
                    <b-button type="is-danger" @click="deleteImage" :loading="loadingDelete">Удалить</b-button>
                    <b-button type="is-success" @click="updateImage" :loading="loadingEdit">Сохранить</b-button>
                </footer>
            </div>
        </b-modal>
    </div>
</template>

<script>
import Images from "./Images"

export default {
    name: "ImagesEdit",
    components: {Images},
    props: ['novel', 'novelPath', 'images'],
    data() {
        return {
            editorOpened: false,
            image_id: null,
            localImage: {
                name: '',
            },
            loadingEdit: false,
            loadingDelete: false,
        }
    },
    computed: {
        image() {
            return this.image_id !== null ? this.images[this.image_id] : null
        }
    },
    watch: {
        image(value) {
            this.localImage.name = value !== null ? value.name : ''
        }
    },
    methods: {
        openEditor(image_id) {
            this.image_id = image_id
            this.editorOpened = true
        },
        deleteImage() {
            this.loadingDelete = true
            axios.delete(this.novelPath + '/images/' + this.image_id)
                .then(({data}) => {
                    const image_id = this.image_id
                    this.image_id = null
                    this.$delete(this.images, image_id)
                    this.loadingDelete = false
                    this.editorOpened = false
                })
                .catch(defaultErrorHandler)
        },
        updateImage() {
            this.loadingEdit = true
            axios.patch(this.novelPath + '/images/' + this.image_id, this.localImage)
                .then(({data}) => {
                    this.images[this.image_id].name = data.image.name
                    this.loadingEdit = false
                    this.editorOpened = false
                })
                .catch(defaultErrorHandler)
        },
    }
}
</script>

<style scoped>

</style>
