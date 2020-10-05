<template>
    <b-navbar :class="{'hidden': hidden}">
        <template slot="brand">
            <b-navbar-item tag="router-link" :to="{ path: '/' }" class="is-monoton is-size-3 has-text-danger">
                Los Cops
            </b-navbar-item>
        </template>
        <template slot="start">
            <b-navbar-item tag="router-link" :to="{ path: '/' }">
                Главная
            </b-navbar-item>
        </template>

        <template slot="end">
            <b-navbar-item tag="div">
                <div class="buttons">
                    <a class="button">
                        Зарегистрироваться
                    </a>
                    <a class="button">
                        Войти
                    </a>
                </div>
            </b-navbar-item>
        </template>
    </b-navbar>
</template>

<script>
export default {
    name: "Navbar",
    props: {
        hidden: {
            default: false,
            type: Boolean,
        }
    }
}
</script>

<style scoped lang="scss">
.hidden {
    position: absolute;
    width: 100%;
    opacity: 0;
    &:hover {
        opacity: 1;
    }
}
</style>
