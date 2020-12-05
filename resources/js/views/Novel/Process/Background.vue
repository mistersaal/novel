<template>
    <div>
        <div class="scene-blur-background">
            <div class="scene-blur" :style="{'background-image': 'url(' + background + ')'}"></div>
        </div>
        <div class="scene is-flex is-justify-content-center is-align-items-center">
            <img class="scene-background" :src="background">
        </div>
    </div>
</template>

<script>
export default {
    name: "Background",
    props: ['background']
}
</script>

<style scoped lang="scss">
.scene-blur {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    filter: blur(5px);
    z-index: -1;
    background-position: center center;
    background-size: cover;

    &-background {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background-color: black;
        z-index: -1;
    }
}

.scene {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.scene-background {
    height: auto;
    max-height: 100%;
    position: relative;
}
</style>
