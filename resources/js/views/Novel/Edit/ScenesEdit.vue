<template>
    <section class="section">
        <div class="container">
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
                        Тут будет форма редактирования сцены и создания следующих
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button" type="button" @click="editScene = false">Отмена</button>
                    </footer>
                </div>
            </b-modal>
        </div>
    </section>
</template>

<script>
import OrgChart from '@balkangraph/orgchart.js'

export default {
    name: "ScenesEdit",
    props: ["novel", "novelPath"],
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
            },
        }
    },
    methods: {
        oc(domEl, x) {
            const editForm = () => {};
            editForm.prototype.init = (obj) => {}
            editForm.prototype.show = (nodeId) => {
                this.editedScene = this.scenes[nodeId]
                this.editScene = true
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
    },

    mounted() {
        this.setTemplates()
        axios.get(this.novelPath + '/edit/scenes')
            .then(({data}) => {
                this.scenes = data
                this.nodes = Object.values(this.scenes)
                this.oc(this.$refs.tree, this.nodes)
            })
            .catch(defaultErrorHandler)
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
