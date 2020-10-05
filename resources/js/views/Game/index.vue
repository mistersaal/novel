<template>
    <div>
        <navbar hidden></navbar>
        <background :background="background"></background>
        <div class="scene-position">
            <div class="scene">
                <b-button class="scene-button">Назад</b-button>
                <div class="text has-text-light">{{ text }}</div>
                <b-button class="scene-button">Дальше</b-button>
            </div>
        </div>
        <action v-if="true"></action>
    </div>
</template>

<script>
import Navbar from "../../components/Navbar"
import Background from "./Background"
import Action from "./Action";

export default {
    name: "Game",
    components: {Action, Background, Navbar},
    data() {
        return {
            background: '/storage/games/1/images/test.jpg',
            text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo impedit provident repellendus. Aliquam deleniti dicta ducimus ea eaque excepturi, hic illum, incidunt natus nostrum numquam qui quis ratione rem rerum ullam velit. Amet architecto blanditiis doloremque enim eveniet excepturi facilis in iusto laudantium magnam nisi non nulla, obcaecati perspiciatis sint suscipit tempora ullam ut vel voluptatem! Adipisci aperiam autem, cum dicta eius inventore nemo quas saepe? A adipisci asperiores atque aut blanditiis consectetur consequuntur deleniti eius et exercitationem facilis illum incidunt itaque, magnam molestias nostrum odit pariatur perspiciatis, possimus qui sapiente sint sit, sunt suscipit tempora tempore temporibus vel veniam.',
        }
    },
}
</script>

<style scoped lang="scss">
.scene-position {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 170px;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

.scene {
    width: 100%;
    height: 100%;
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
    }
}
</style>
