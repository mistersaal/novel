<template>
    <b-modal :active="true" has-modal-card>
        <div class="modal-card" style="width: 400px">
            <header class="modal-card-head">
                <p class="modal-card-title">{{ question }}</p>
                <button
                    type="button"
                    class="delete"
                    @click="$emit('close')"/>
            </header>
            <section class="modal-card-body">
                <div class="action" v-for="choice in choices">
                    <div class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <p>{{ choice.value }}</p>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <b-button @click="$emit('chose', choice.id)">▶</b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
            </footer>
        </div>
    </b-modal>
</template>

<script>
export default {
    name: "Action",
    props: {
        choices: {
            type: Array,
            default: [],
        },
        question: {
            type: String,
            default: '',
        }
    },
}
</script>

<style scoped lang="scss">
.action {
    margin: 10px 0;
}
</style>
