<template>
    <section class="section">
        <div class="container">
            <p>
                Изучаю <a href="https://balkangraph.com/OrgChartJS/Docs/GettingStarted" target="_blank">библиотеку</a>,
                на основе которой можно построить древовидный конструктор
                (ниже пример дерева, взятый из доки, можно полностью под себя переделать)
            </p>
            <div id="tree" ref="tree"></div>
        </div>
    </section>
</template>

<script>
import OrgChart from '@balkangraph/orgchart.js'

export default {
    name: "ScenesEdit",
    data() {
        return {
            nodes: [
                {id: 1, name: "Denny Curtis", title: "CEO", img: "https://cdn.balkan.app/shared/2.jpg"},
                {
                    id: 2,
                    pid: 1,
                    name: "Ashley Barnett",
                    title: "Sales Manager",
                    img: "https://cdn.balkan.app/shared/3.jpg"
                },
                {
                    id: 3,
                    pid: 1,
                    name: "Caden Ellison",
                    title: "Dev Manager",
                    img: "https://cdn.balkan.app/shared/4.jpg"
                },
                {id: 4, pid: 2, name: "Elliot Patel", title: "Sales", img: "https://cdn.balkan.app/shared/5.jpg"},
                {id: 5, pid: 2, name: "Lynn Hussain", title: "Sales", img: "https://cdn.balkan.app/shared/6.jpg"},
                {id: 6, pid: 3, name: "Tanner May", title: "Developer", img: "https://cdn.balkan.app/shared/7.jpg"},
                {id: 7, pid: 3, name: "Fran Parsons", title: "Developer", img: "https://cdn.balkan.app/shared/8.jpg"}
            ]
        }
    },
    methods: {
        oc: function (domEl, x) {

            this.chart = new OrgChart(domEl, {
                nodes: x,
                nodeBinding: {
                    field_0: "name",
                    field_1: "title",
                    img_0: "img"
                }
            });

        }
    },

    mounted() {
        this.oc(this.$refs.tree, this.nodes)
    }
}
</script>

<style scoped>

</style>
