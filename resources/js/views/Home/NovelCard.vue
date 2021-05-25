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
            <div class="card-content fixed-height is-flex is-align-items-center is-justify-content-center">
                <div class="media">
                    <div class="media-content">
                        <p class="title" :class="headerSize">
                            {{ novel.name }}
                            <template v-if="novel.is_banned">
                                <br>❌
                            </template>
                        </p>
                        <p class="subtitle is-6">
                            @{{ author }}
                            <template v-if="isAuthorBanned">
                                <br>❌
                            </template>
                        </p>
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
        isAuthorBanned() {
            return this.userIsAuthor ? false : this.novel.author.is_banned
        },
        linkTo() {
            return {name: 'Novel', params: {id: this.novel.id}}
        },
        headerSize() {
            return this.novel.name.length > 20 ? 'is-5' : 'is-4'
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
.fixed-height {
    height: 126px;
}
</style>
