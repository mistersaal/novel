<template>
    <b-modal :active="true" has-modal-card>
        <div class="modal-card" style="width: 400px">
            <header class="modal-card-head">
                <p class="modal-card-title">Выберите...</p>
                <button
                    type="button"
                    class="delete"
                    @click="$emit('close')"/>
            </header>
            <section class="modal-card-body">
                <div class="action">
                    <div class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <p>1 вариант действия</p>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <b-button>▶</b-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="action">
                    <div class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <p>2 вариант действия</p>
                            </div>
                        </div>
                        <div class="level-right">
                            <div class="level-item">
                                <b-button>▶</b-button>
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
name: "Action"
}
</script>

<style scoped lang="scss">
.action {
    margin: 10px 0;
}
</style>
