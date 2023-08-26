<template>
    <v-dialog
        v-model="dialog"
        width="500"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                color="primary"
                dark
                v-bind="attrs"
                v-on="on"
            >
                Импорт участников
            </v-btn>
        </template>

        <v-card>
            <v-toolbar color="primary" dark>
                Импорт участников
            </v-toolbar>
            <v-divider class="mb-6"></v-divider>
            <v-card-text>
                <v-form v-model="valid">
                    <v-row>
                        <v-col>
                            После загрузки файла, пользователи будут автоматически импортированы в систему и приседенины к вашему мероприятию.
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <AttachmentUploader
                                v-model="file.file_id"
                                label="Таблица пользователей"
                                accept=".xls, .xlsx"
                                icon="mdi-download"
                            />
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-spacer />
                <v-btn
                    color="light"
                    nuxt
                    disabled
                >
                    Отменить
                </v-btn>
                <v-btn
                    color="primary"
                    nuxt
                    :loading="LOADING_STATUS"
                    @click="save"
                    :disabled="!valid"
                >
                    Импортировать
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script>
  import { mapGetters, mapActions, mapMutations } from "vuex";

  export default {
    computed: {
      ...mapGetters({
        LOADING_STATUS: "user/LOADING_STATUS",
      }),
    },
    methods: {
      ...mapActions({
        importUsers: "user/importUsers",
      }),
      // Метод обновления данных
      async save(){
        await this.importUsers(this.file);
      },
    },
    data () {
      return {
        valid: false,
        dialog: false,
        file: {
            file_id: null,
        },
        // Валидаторы
        group: [
          value => {
            if (value) return true
            return 'Обязательно для заполнения.'
          },
        ],
      };
    },
  }
</script>
