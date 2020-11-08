<template>
    <router-link :to="linkTo">
        <div class="card rounded">
            <div class="card-image">
                <figure class="image">
                    <figure class="cover"
                         :style="novel.cover ? {'background-image': 'url(' + novel.cover.path + ')'} : {}"
                    ></figure>
                </figure>
            </div>
            <div class="card-content">
                <div class="media">
                    <div class="media-content">
                        <p class="title is-4">{{ novel.name }}</p>
                        <p class="subtitle is-6">@{{ author }}</p>
                    </div>
                </div>
            </div>
        </div>
    </router-link>
</template>

<script>
export default {
    name: "NovelCard",
    props: {
        novel: {
            default: {},
            type: Object
        },
        userIsAuthor: {
            default: false,
            type: Boolean
        },
    },
    computed: {
        author() {
            return this.userIsAuthor ? this.$store.state.user.name : this.novel.author.name
        },
        linkTo() {
            return {name: 'Novel', params: {id: this.novel.id}}
        }
    },

}
</script>

<style scoped>
.rounded {
    border-radius: 8px;
}
.cover {
    border-radius: 8px 8px 0 0;
    height: 150px;
    width: 100%;
    background-position: center;
    background-size: cover;
    background-color: lightgray;
}
</style>
