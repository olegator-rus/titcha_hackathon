<template>
   <v-card :loading="LOADING_STATUS">
    <v-card-title class="headline">
      Редактор данных участника
    </v-card-title>
    <v-divider class="mb-6"></v-divider>
    <v-card-text>
      <v-form v-model="valid">
        <v-row>
            <v-col>
                <v-text-field
                v-model="user.email"
                :rules="nameRules"
                :counter="35"
                label="E-mail адрес пользователя"
                outlined
                required
                ></v-text-field>
            </v-col>
          <v-col>
            <v-text-field
              v-model="user.surname"
              :rules="nameRules"
              :counter="35"
              label="Фамилия пользователя"
              outlined
              required
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              v-model="user.name"
              :rules="nameRules"
              :counter="35"
              label="Имя пользователя"
              outlined
              required
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              v-model="user.patronymic"
              :rules="nameRules"
              :counter="35"
              label="Отчество пользователя"
              outlined
              required
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              v-model="user.address"
              :counter="60"
              label="Адрес пользователя"
              outlined
              required
            ></v-text-field>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
    <v-divider></v-divider>
    <v-card-actions>
      <v-spacer />
      <v-btn
        color="primary"
        nuxt
        :loading="LOADING_STATUS"
        @click="save"
      >
        Сохранить
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
  import { mapGetters, mapActions, mapMutations } from "vuex";

  export default {
        computed: mapGetters({
            USER: "user/USER",
            LOADING_STATUS: "user/LOADING_STATUS",
        }),

        methods: {

            ...mapActions({
                updateUser: "user/updateUser",
            }),

            // Обходим все свойства объекта event
            // и загружаем туда одноименные значения из VUEX
            recollectData(){
                Object.keys(this.user).forEach((key, value) => {
                    this.user[key] = this.USER[key];
                });
            },

            // Метод обновления данных
            async save(){
                await this.updateUser(this.user);
            },
        },
        mounted() {
            // При инициализации пересобираем данные.
            this.recollectData();
        },
        data: () => ({
            valid: false,
            user: {
                id: null,
                email: null,
                name: null,
                surname: null,
                patronymic: null,
                address: null,
            },
            // Валидаторы
            nameRules: [
                value => {
                    if (value) return true
                    return 'Обязательно для заполнения.'
                },
                value => {
                    if (value?.length <= 35) return true
                    return 'Название целевой группы должно быть мнее 35 символов.'
                },
            ],
        }),
    }
</script>
