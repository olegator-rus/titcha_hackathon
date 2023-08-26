<template>
    <v-card :loading="LOADING_STATUS">
        <v-card-title>
            Участники
            <v-spacer></v-spacer>
            <UserImport />
        </v-card-title>
        <v-divider></v-divider>
        <v-data-table
            no-data-text="Участники в систему еще не добавлены"
            no-results-text="Поиск не дал результатов"
            :footer-props="{'items-per-page-text': 'Строк в таблице'}"
            :headers="headers"
            :items="USERS_LIST"
            @click:row="openEditor"
        >

            <template v-slot:item.email="{ item }">
                <span v-if="item.email">{{ item.email }}</span>
                <span v-else>Не указано</span>
            </template>
            <template v-slot:item.user.name="{ item }">
                <span v-if="item.user.name">{{ item.user.name }}</span>
                <span v-else>Не указано</span>
            </template>
            <template v-slot:item.user.surname="{ item }">
                <span v-if="item.user.surname">{{ item.user.surname }}</span>
                <span v-else>Не указано</span>
            </template>
            <template v-slot:item.user.patronymic="{ item }">
                <span v-if="item.user.patronymic">{{ item.user.patronymic }}</span>
                <span v-else>Не указано</span>
            </template>
            <template v-slot:item.created_at="{ item }">
                {{ $moment(item.created_at).format("Do MMMM yyyy") }}
            </template>
        </v-data-table>
    </v-card>
</template>


<script>
  import { mapGetters, mapActions, mapMutations } from "vuex";

  export default {
    computed: mapGetters({
        USERS_LIST:  "user/USERS_LIST",
        LOADING_STATUS: "user/LOADING_STATUS",
    }),
    methods: {
        ...mapActions({
            getAllUsers: "user/getAllUsers"
        }),
        openEditor(row) {
            this.$router.push({ path: `/manager/user/${row.user_id}` });
        },
    },
    data () {
        return {
            headers: [
                {
                    text: 'E-mail адрес',
                    align: 'start',
                    sortable: false,
                    value: 'user.email',
                },
                {
                    text: 'Фамилия',
                    align: 'start',
                    sortable: false,
                    value: 'user.surname',
                },
                {
                    text: 'Имя',
                    align: 'start',
                    sortable: false,
                    value: 'user.name',
                },
                {
                    text: 'Отчество',
                    align: 'start',
                    sortable: false,
                    value: 'user.patronymic',
                },
                {
                    text: 'Дата подключения',
                    value: 'created_at'
                },
            ]
        }
    },
  }
</script>
