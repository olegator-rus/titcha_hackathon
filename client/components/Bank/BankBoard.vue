<template>
    <v-row>
      <v-col cols="12" sm="12" md="12">
          <v-card>
              <v-toolbar flat>
                  <v-toolbar-title>
                      Список подключений к АИС (банков)
                  </v-toolbar-title>
              </v-toolbar>

              <v-data-table
                  no-data-text="Банки в систему еще не добавлены"
                  no-results-text="Поиск не дал результатов"
                  :footer-props="{'items-per-page-text': 'Строк в таблице'}"
                  :headers="headers"
                  :items="BANKS_LIST"
                  @click:row="handleClick"
              ></v-data-table>
          </v-card>
      </v-col>
    </v-row>
  </template>

  <script>
  import { mapGetters, mapActions, mapMutations } from "vuex";

  export default {

        computed: mapGetters({
            BANKS_LIST: "bank/BANKS_LIST",
        }),

        methods: {
            handleClick(row) {
                this.$router.push({ path: `bank/${row.id}` });
            },
        },

        data () {
            return {
                headers: [
                    {
                        text: 'Название банка',
                        align: 'start',
                        sortable: false,
                        value: 'name',
                    },
                    {
                        text: 'Страна',
                        align: 'start',
                        sortable: false,
                        value: 'country',
                    },
                    {
                        text: 'SWIFT-код',
                        align: 'start',
                        sortable: false,
                        value: 'swift_code',
                    }
                ],
        }
      }
  }
  </script>
