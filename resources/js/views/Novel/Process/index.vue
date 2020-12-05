<template>
    <div>
        <navbar hidden></navbar>
        <b-loading :active="!sceneIsLoaded" is-full-page></b-loading>
        <template v-if="sceneIsLoaded">
            <background :background="scene.image.path"></background>
            <div class="scene-position">
                <div class="scene">
                    <b-button class="scene-button left" @click="prev" :disabled="isFirstScene">Назад</b-button>
                    <div class="text has-text-light center">А вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллыА вот первая сцена нашей новеллы</div>
                    <b-button class="scene-button right" @click="next" :disabled="isLastScene">Дальше</b-button>
                </div>
            </div>
            <action v-if="choiceRequired"
                    :choices="scene.choices"
                    @close="choiceRequired = false"
                    @chose="sendChoiceAndLoadScene"
            ></action>
        </template>
    </div>
</template>

<script>
import Navbar from "../../../components/Navbar"
import Background from "./Background"
import Action from "./Action";

export default {
    name: "NovelProcess",
    components: {Action, Background, Navbar},
    data() {
        return {
            sceneIsLoaded: false,
            choiceRequired: false,
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
            scene: {
                id: 0,
                text: "",
                image: {
                    id: 0,
                    name: "",
                    path: ""
                },
                music: null,
                choices: [],
                last_scene: false
            },
        }
    },
    computed: {
        id() {
            return this.$route.params['id']
        },
        novelPath() {
            return '/api/novels/' + this.id
        },
        isFirstScene() {
            return this.novel.first_scene_id === this.scene.id
        },
        isLastScene() {
            return this.scene.last_scene
        }
    },
    created() {
        axios.get(this.novelPath).then(({data}) => {
            this.novel = data.novel
            axios.get(this.novelPath + '/scene').then(({data}) => {
                this.scene = data.scene
                this.sceneIsLoaded = true
            }).catch(defaultErrorHandler)
        }).catch(defaultErrorHandler)
    },
    methods: {
        next() {
            if (this.scene.choices.length) {
                this.choiceRequired = true
            } else {
                this.sendChoiceAndLoadScene()
            }
        },
        sendChoiceAndLoadScene(choice = null) {
            this.choiceRequired = false
            this.sceneIsLoaded = false
            let sentData = {}
            if (choice) {
                sentData.choice = choice
            }
            axios.post(this.novelPath + '/scene/next', sentData).then(({data}) => {
                this.scene = data.scene
                this.sceneIsLoaded = true
            }).catch(error => {
                this.sceneIsLoaded = true
                this.$buefy.notification.open({
                    message: error.response.data.message ?? 'Неизвестная ошибка',
                    type: 'is-warning',
                    duration: 10000
                })
            })
        },
        prev() {
            this.sceneIsLoaded = false
            axios.post(this.novelPath + '/scene/previous').then(({data}) => {
                this.scene = data.scene
                this.sceneIsLoaded = true
            })
        },
    },
    mounted() {
        document.querySelector('html').style['overflow-y'] = 'hidden'
    },
    beforeDestroy() {
        document.querySelector('html').style['overflow-y'] = ''
    }
}
</script>

<style scoped lang="scss">
.scene-position {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    min-height: 170px;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

.scene {
    width: 100%;
    height: 100%;
    min-height: 170px;
    max-height: 300px;
    max-width: 1360px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 20px;

    & .scene-button {
        width: 100px;
    }
    & .text {
        margin: 0 30px;
        height: 100%;
        overflow-y: auto;
        width: 100%;
        max-height: 200px;
    }

    @media (max-width: 768px) {
        & {
            flex-wrap: wrap;
        }
        & .left {
            order: 2;
        }
        & .center {
            order: 1;
        }
        & .right {
            order: 3;
        }
        & .text {
            margin: 0 0 15px 0;
        }
    }
}
</style>
