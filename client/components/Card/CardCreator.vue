<template>
    <v-dialog
        v-model="dialog"
        overlay-color="black"
        overlay-opacity="0.7"
        width="500"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-btn
                v-bind="attrs"
                v-on="on"
                icon>
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-toolbar color="primary" dark>
                Открыть новую карту
            </v-toolbar>
            <v-divider class="mb-6"></v-divider>

            <v-card-text>
                <v-form v-model="valid">
                    <v-row>
                        <v-col>
                            <v-select
                                v-model="form.currencyId"
                                :items="CURRENCIES_SELECT_LIST"
                                label="Валюта карты"
                                no-data-text="Нет доступных для выбора валют"
                                item-text="name"
                                item-value="id"
                                outlined
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-select
                                v-model="form.bankId"
                                :items="BANKS_SELECT_LIST"
                                label="Банк (эмитент) карты"
                                no-data-text="Нет доступных банков"
                                item-text="name"
                                item-value="id"
                                outlined
                            ></v-select>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>

            <v-divider></v-divider>

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
                    @click="create"
                    :loading="LOADING_STATUS"
                >
                    Сохранить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {
    computed: mapGetters({
        CURRENCIES_SELECT_LIST: "currency/CURRENCIES_SELECT_LIST",
        BANKS_SELECT_LIST: "bank/BANKS_SELECT_LIST",
        LOADING_STATUS: "wallet/LOADING_STATUS",
    }),
    methods: {
        ...mapActions({
            getMyCards: "card/getMyCards",
            createCard: "card/createCard",
        }),

        async create(){
            await this.createCard(this.form);
            await this.getMyCards();
            this.dialog = false;
        }
    },
    data () {
        return {
            valid: true,
            dialog: false,
            form: {
                currencyId: null,
                bankId: null,
            }
        }
    },
}
</script>
