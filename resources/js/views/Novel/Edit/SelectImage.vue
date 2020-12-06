<template>
    <b-modal :active="active" :can-cancel="['escape', 'outside']" @close="$emit('update:active', false)">
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Выбрать изображение</p>
                <button
                    type="button"
                    class="delete"
                    @click="$emit('update:active', false)"/>
            </header>
            <section class="modal-card-body">
                <images :novel="novel" :novel-path="novelPath" :images="images" @image="setImage($event)"></images>
            </section>
            <footer class="modal-card-foot">
                <button class="button" type="button" @click="$emit('update:active', false)">Отмена</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
import Images from "./Images"
export default {
    name: "SelectImage",
    components: {Images},
    props: {
        active: {
            type: Boolean,
            default: false,
        },
        images: {
            type: Object,
            default: {},
        },
        novel: {
            type: Object,
            default: {},
        },
        novelPath: {
            type: String,
            default: '',
        }
    },
    methods: {
        setImage(image_id) {
            this.$emit('image', image_id)
            this.$emit('update:active', false)
        }
    }
}
</script>

<style scoped>

</style>
