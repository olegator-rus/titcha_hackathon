<template>
    <v-app>
        <v-navigation-drawer v-model="drawer" :clipped="clipped" fixed app>
            <!-- Карточка пользователя -->
            <template v-slot:prepend>
                <v-list-item two-line>
                <v-list-item-avatar>
                    <v-avatar color="info" size="100">
                    {{ Array.from($auth.user.name)[0] }}
                    </v-avatar>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title>{{ $auth.user.name }}</v-list-item-title>
                    <v-list-item-subtitle v-if="$auth.user.roles.find(role => role.name === 'client')">Пользователь</v-list-item-subtitle>
                    <v-list-item-subtitle v-if="$auth.user.roles.find(role => role.name === 'manager')">Менеджер</v-list-item-subtitle>
                    <v-list-item-subtitle v-if="$auth.user.roles.find(role => role.name === 'admin')">Администратор</v-list-item-subtitle>
                </v-list-item-content>
                </v-list-item>
            </template>
            <v-divider></v-divider>

            <v-list>
                <v-list-item
                    v-for="(item, i) in menu"
                    :key="i"
                    :to="item.to"
                    router
                    exact
                >
                    <v-list-item-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.title" />
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <template v-slot:append>
                <div class="pa-2">
                <v-btn block @click="$auth.logout()">
                    Выйти из системы
                </v-btn>
                </div>
            </template>
        </v-navigation-drawer>


        <v-app-bar :clipped-left="clipped" fixed app>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <img class="ml-6" :src="require('../assets/logo.png')" height="35" />
            <v-spacer />
        </v-app-bar>
        <v-main>
            <v-container>
                <Nuxt class="mb-14"/>
                <FooterArea />
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";
import routes from "~/assets/json/routes/routes.json";

export default {
    data () {
        return {
            clipped: true,
            drawer: true,
            title: 'ИЗЮМ',
        }
    },
    computed: {
        menu() {
            // Список ролей пользователя
            const roles = this.$auth.user.roles.map(role => role.name);
            // Фильтрация
            return routes.filter((route) => {
                // Если существуют пересечения в объекте настроек модулей
                // с фактической конфигурацией, возвращенной сервером -
                // добавляем в объект в меню.
                return !!roles.filter(x => route.roles.includes(x)).length;
            });
        }
    },
}
</script>
