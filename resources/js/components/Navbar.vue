<template>
    <b-navbar :class="{'hidden': hidden}">
        <template slot="brand">
            <b-navbar-item tag="router-link" :to="{name: 'Home'}" class="is-monoton is-size-3 has-text-danger">
                MyNovel.ml
            </b-navbar-item>
        </template>
        <template slot="start">
            <b-navbar-item tag="router-link" :to="{name: 'Home'}">
                Главная
            </b-navbar-item>
        </template>

        <template slot="end">
            <b-navbar-item tag="div">
                <div class="buttons">
                    <template v-if="$store.state.user === null">
                        <router-link class="button" :to="{name: 'Register'}">
                            Зарегистрироваться
                        </router-link>
                        <router-link class="button" :to="{name: 'Login'}">
                            Войти
                        </router-link>
                    </template>
                    <template v-else>
                        <b-button @click="editProfile">
                            Редактировать профиль
                        </b-button>
                        <b-button @click="logout" :loading="loggingOut">
                            Выйти
                        </b-button>
                    </template>
                </div>
            </b-navbar-item>
        </template>
    </b-navbar>
</template>

<script>
export default {
    name: "Navbar",
    data() {
        return {
            loggingOut: false,
        }
    },
    props: {
        hidden: {
            default: false,
            type: Boolean,
        }
    },
    methods: {
        logout() {
            this.loggingOut = true
            axios.post('/logout').then(() => {
                this.$store.commit('setUser', null)
                this.loggingOut = false
                this.$router.push({name: 'Login'})
            })
        },
        editProfile() {
            this.$buefy.dialog.prompt({
                message: 'Изменить имя профиля',
                inputAttrs: {
                    type: 'text',
                    placeholder: 'Имя профиля',
                    value: this.$store.state.user.name,
                },
                confirmText: 'Сохранить',
                cancelText: 'Отмена',
                closeOnConfirm: false,
                trapFocus: true,
                onConfirm: (value) => {
                    this.$buefy.toast.open(`Профиль сохраняется...`)
                    axios.patch('/api/user/', {
                        name: value,
                    }).then(() => {
                        this.$router.go()
                    })
                }
            })
        }
    },
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
