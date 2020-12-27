<template>
    <section class="section">
        <div class="container">
            <b-button type="is-text" @click="toFullScreen">Развернуть на весь экран</b-button>
            <div id="fullscreen">
                <div id="tree" ref="tree" class="box tree"></div>
                <b-modal :active="editScene" :can-cancel="['escape', 'outside']" @close="editScene = false">
                    <div class="modal-card" style="width: auto">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Сцена</p>
                            <button
                                type="button"
                                class="delete"
                                @click="editScene = false"/>
                        </header>
                        <section class="modal-card-body">
                            <b-field label="Название сцены">
                                <b-input v-model="editedScene.name"></b-input>
                            </b-field>
                            <label class="label">Фон сцены</label>
                            <b-field class="file" :class="{'has-name': !!editedScene.image_id}" @click="sceneChoosingImage = true">
                                <div class="file-label" @click="sceneChoosingImage = true">
                                <span class="file-cta">
                                    <span class="file-label">{{ !!editedScene.image_id ? 'Изменить' : 'Выбрать' }} обложку</span>
                                </span>
                                    <span class="file-name" v-if="editedScene.image_id">
                                    {{ images[editedScene.image_id] ? images[editedScene.image_id].name : '' }}
                                </span>
                                </div>
                            </b-field>
                            <b-field label="Текст">
                                <b-input type="textarea" v-model="editedScene.text"></b-input>
                            </b-field>
                            <b-field label="Вопрос после сцены" :addons="false" v-if="editedScene.hasQuestion">
                                <b-input v-model="editedScene.question"></b-input>
                                <p class="help">Можно оставить пустым, если после сцены нет выбора</p>
                            </b-field>
                            <b-field label="Значение выбора" v-if="editedScene.question && editedScene.id !== 0 && editedScene.choice">
                                <b-input v-model="editedScene.choice_value"></b-input>
                            </b-field>
                            <select-image :active.sync="sceneChoosingImage"
                                          :images="images"
                                          @image="editedScene.image_id = $event"
                                          :novel="novel"
                                          :novel-path="novelPath"
                            >
                            </select-image>
                            <b-field v-if="isAbleCreateNewScene(editedScene.id)">
                                <b-button @click="openNewSceneForm" type="is-primary">
                                    Создать следующую сцену
                                </b-button>
                            </b-field>
                        </section>
                        <footer class="modal-card-foot">
                            <b-button @click="editScene = false">Отмена</b-button>
                            <b-button @click="saveScene" type="is-success" :loading="saveLoad">Сохранить</b-button>
                            <b-button @click="deleteScene" type="is-danger" :loading="deletingLoad">Удалить</b-button>
                        </footer>
                    </div>
                </b-modal>
                <b-modal :active="creatingScene" :can-cancel="['escape', 'outside']" @close="creatingScene = false">
                    <div class="modal-card" style="width: auto">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Новая сцена</p>
                            <button
                                type="button"
                                class="delete"
                                @click="creatingScene = false"/>
                        </header>
                        <section class="modal-card-body">
                            <b-field label="Название сцены">
                                <b-input v-model="newScene.name"></b-input>
                            </b-field>
                            <label class="label">Фон сцены</label>
                            <b-field class="file" :class="{'has-name': !!newScene.image_id}" @click="newSceneChoosingImage = true">
                                <div class="file-label" @click="newSceneChoosingImage = true">
                                <span class="file-cta">
                                    <span class="file-label">{{ !!newScene.image_id ? 'Изменить' : 'Выбрать' }} обложку</span>
                                </span>
                                    <span class="file-name" v-if="newScene.image_id">
                                    {{ images[newScene.image_id] ? images[newScene.image_id].name : '' }}
                                </span>
                                </div>
                            </b-field>
                            <b-field label="Текст">
                                <b-input type="textarea" v-model="newScene.text"></b-input>
                            </b-field>
                            <b-field label="Вопрос после сцены" :addons="false">
                                <b-input v-model="newScene.question"></b-input>
                                <p class="help">Можно оставить пустым, если после сцены нет выбора</p>
                            </b-field>
                            <b-field label="Значение выбора" v-if="editedScene.question && editedScene.id !== 0">
                                <b-input v-model="newScene.choice_value"></b-input>
                            </b-field>
                            <select-image :active.sync="newSceneChoosingImage"
                                          :images="images"
                                          @image="newScene.image_id = $event"
                                          :novel="novel"
                                          :novel-path="novelPath"
                            >
                            </select-image>
                        </section>
                        <footer class="modal-card-foot">
                            <b-button @click="createScene" type="is-primary" :loading="creatingLoad">Создать</b-button>
                            <b-button @click="creatingScene = false">Отмена</b-button>
                        </footer>
                    </div>
                </b-modal>
            </div>
        </div>
    </section>
</template>

<script>
import OrgChart from '@balkangraph/orgchart.js'
import SelectImage from "./SelectImage";

export default {
    name: "ScenesEdit",
    components: {SelectImage},
    props: ["novel", "novelPath", "images"],
    data() {
        return {
            scenes: {},
            nodes: [],
            chart: {},
            editScene: false,
            editedScene: {
                id: 0,
                pid: 0,
                img: "",
                choice: "",
                question: "",
                text: "",
                image_id: null,
                hasQuestion: false,
            },
            editedNodeId: 0,
            creatingScene: false,
            newScene: {
                name: '',
                image_id: null,
                text: '',
                music_id: null,
                question: null,
                parent_scene_id: null,
                choice_value: null,
            },
            newSceneChoosingImage: false,
            sceneChoosingImage: false,
            creatingLoad: false,
            deletingLoad: false,
            saveLoad: false,
            mounted: true,
        }
    },
    methods: {
        oc(domEl, x) {
            const editForm = () => {};
            editForm.prototype.init = (obj) => {}
            editForm.prototype.show = (nodeId) => {
                this.editedNodeId = this.nodes.indexOf(this.scenes[nodeId])
                this.editedScene = _.clone(this.scenes[nodeId])
                this.editedScene.hasQuestion = this.editedScene.question !== '' && this.editedScene.question !== null
                if (nodeId === 0) {
                    this.creatingScene = true
                } else {
                    this.editScene = true
                }
            }
            editForm.prototype.hide = (showldUpdateTheNode) => {
                this.editScene = false
            }
            this.chart = new OrgChart(domEl, {
                template: "novelScenes",
                nodes: x,
                nodeBinding: {
                    field_0: "name",
                    field_1: "question",
                    img_0: "img"
                },
                linkBinding: {
                    link_field_0: "choice"
                },
                editUI: new editForm(),
            });
        },
        setTemplates() {
            OrgChart.templates.ana.link
            OrgChart.templates.novelScenes = Object.assign({}, OrgChart.templates.ana)
            OrgChart.templates.novelScenes.defs += '<filter id="dropshadow" height="130%">\n' +
                                                    '  <feGaussianBlur in="SourceAlpha" stdDeviation="10"/> <!-- stdDeviation is how much to blur -->\n' +
                                                    '  <feOffset dx="0" dy="7" result="offsetblur"/> <!-- how much to offset -->\n' +
                                                    '  <feComponentTransfer>\n' +
                                                    '    <feFuncA type="linear" slope="0.07"/> <!-- slope is the opacity of the shadow -->\n' +
                                                    '  </feComponentTransfer>\n' +
                                                    '  <feMerge> \n' +
                                                    '    <feMergeNode/> <!-- this contains the offset blurred image -->\n' +
                                                    '    <feMergeNode in="SourceGraphic"/> <!-- this contains the element that the filter is applied to -->\n' +
                                                    '  </feMerge>\n' +
                                                    '</filter>\n';
            OrgChart.templates.novelScenes.size = [300, 200];
            OrgChart.templates.novelScenes.node = '<rect fill="#0081e0" rx="12" ry="12" width="300" height="200" style="filter:url(#dropshadow)"></rect>';
            OrgChart.templates.novelScenes.field_0 = '<text style="font-size: 24px;" fill="#ffffff" x="150" y="140" text-anchor="middle">{val}</text>';
            OrgChart.templates.novelScenes.field_1 = '<text style="font-size: 16px;" fill="#ffffff" x="150" y="170" text-anchor="middle">{val}</text>';
            OrgChart.templates.novelScenes.img_0 = '<clipPath id="ulaImg"><rect fill="#0081e0" rx="12" ry="12" width="300" height="200"></rect></clipPath>' +
                                                    '<image preserveAspectRatio="xMidYMid slice" clip-path="url(#ulaImg)" xlink:href="{val}" x="0" y="0"  width="300" height="100"></image>';
            OrgChart.templates.novelScenes.link_field_0 = '<text text-anchor="middle" fill="#000000" width="290" x="0" y="0">{val}</text>';
        },
        createScene() {
            this.creatingLoad = true
            axios.post(this.novelPath + '/edit/scenes', this.newScene)
                .then(({data}) => {
                    if (this.scenes[0] !== undefined) {
                        this.$delete(this.scenes, 0)
                        this.nodes = []
                    }
                    this.$nextTick(() => {
                        this.$set(this.scenes, data.scene.id, {
                            'id': data.scene.id,
                            'pid': this.newScene.parent_scene_id,
                            'name': data.scene.name,
                            'img': data.scene.image ? data.scene.image.path : null,
                            'question': this.newScene.question,
                            'choice': this.newScene.choice_value,
                            'text': data.scene.text,
                            'image_id': data.scene.image ? data.scene.image.id : null,
                        })
                        this.$nextTick(() => {
                            this.nodes.push(this.scenes[data.scene.id])
                            this.oc(this.$refs.tree, this.nodes)
                            this.chart.center(data.scene.id)
                            this.creatingLoad = false
                            this.creatingScene = false
                            this.editScene = false
                        })
                    })
                })
                .catch((error) => {
                    this.creatingLoad = false
                    defaultErrorHandler(error)
                })
        },
        saveScene() {
            this.saveLoad = true
            axios.patch(this.novelPath + '/edit/scenes/' + this.editedScene.id, this.editedScene)
                .then(({data}) => {
                    this.$set(this.scenes, data.scene.id, {
                        'id': data.scene.id,
                        'pid': this.editedScene.pid,
                        'name': data.scene.name,
                        'img': data.scene.image ? data.scene.image.path : null,
                        'question': this.editedScene.question,
                        'choice': this.editedScene.choice_value,
                        'text': data.scene.text,
                        'image_id': data.scene.image ? data.scene.image.id : null,
                    })
                    this.$nextTick(() => {
                        this.nodes[this.editedNodeId] = this.scenes[data.scene.id]
                        this.oc(this.$refs.tree, this.nodes)
                        this.chart.center(data.scene.id)
                        this.saveLoad = false
                        this.editScene = false
                    })
                })
                .catch((error) => {
                    this.creatingLoad = false
                    defaultErrorHandler(error)
                })
        },
        openNewSceneForm() {
            this.newScene = {
                name: '',
                image_id: null,
                text: '',
                music_id: null,
                question: null,
                parent_scene_id: this.editedScene.id,
                choice_value: null,
            }
            this.creatingScene = true
        },
        toFullScreen() {
            const elem = document.getElementById('fullscreen');
            if(document.webkitFullscreenElement) {
                document.webkitCancelFullScreen();
            } else {
                elem.webkitRequestFullScreen();
            }
        },
        deleteScene() {
            this.deletingLoad = true
            axios.delete(this.novelPath + '/edit/scenes/' + this.editedScene.id)
                .then(() => {
                    let center = null
                    if (this.editedScene.pid !== undefined && this.editedScene.pid !== null) {
                        center = this.editedScene.pid
                    }
                    this.loadTree(() => {
                        this.deletingLoad = false
                        this.editScene = false
                    }, center)
                })
                .catch((error) => {
                    this.deletingLoad = false
                    defaultErrorHandler(error)
                })
        },
        loadTree(callback = () => {}, nodeIdCenter = null) {
            this.setTemplates()
            axios.get(this.novelPath + '/edit/scenes')
                .catch(defaultErrorHandler)
                .then(({data}) => {
                    if (data.length === 0) {
                        data = {
                            0: {
                                id: 0,
                                name: 'Создать первую сцену',
                                question: 'Нажмите, чтобы создать',
                                img: this.novel.cover ? this.novel.cover.path : ''
                            }
                        }
                    }
                    this.scenes = data
                    this.nodes = Object.values(this.scenes)
                    if (this.mounted) {
                        this.oc(this.$refs.tree, this.nodes)
                        if (nodeIdCenter) {
                            this.chart.center(nodeIdCenter)
                        }
                        callback()
                    }
                })
        },
        isAbleCreateNewScene(nodeId) {
            let hasQuestion = false
            if (this.scenes[nodeId]) {
                hasQuestion = !!this.scenes[nodeId].question
            }
            return hasQuestion || !_.some(this.nodes, (node) => {
                return node.pid === nodeId
            })
        }
    },

    mounted() {
        this.loadTree()
    },
    beforeDestroy() {
        this.mounted = false
    }
}
</script>

<style scoped lang="scss">

.tree {
    height: 900px;
    width: auto;
}

.svg-box {

}

</style>
