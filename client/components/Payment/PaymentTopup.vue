<template>
    <v-card>
        <v-toolbar flat>
            <v-toolbar-title>
                Пополнение основого счета
            </v-toolbar-title>
        </v-toolbar>
        <v-card-text>
            <v-row>
                <v-col>
                    <v-text-field
                        type="text"
                        label="Владелец карты"
                        persistent-hint
                        hide-spin-buttons
                        outlined
                    ></v-text-field>
                </v-col>
                <v-col>
                    <v-text-field
                        type="number"
                        label="Номер карты"
                        persistent-hint
                        hide-spin-buttons
                        outlined
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field
                        type="number"
                        label="Месяц истечения"
                        persistent-hint
                        hide-spin-buttons
                        outlined
                    ></v-text-field>
                </v-col>
                <v-col>
                    <v-text-field
                        type="number"
                        label="Год истечения"
                        persistent-hint
                        hide-spin-buttons
                        outlined
                    ></v-text-field>
                </v-col>
                <v-col>
                    <v-text-field
                        type="number"
                        label="CVC"
                        persistent-hint
                        hide-spin-buttons
                        outlined
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-text>
            <v-row>
                <v-col cols="8">
                    <v-select
                        v-model="form.accountId"
                        :items="ACCOUNT_SELECT_LIST"
                        label="Пополняемый аккаунт"
                        no-data-text="Нет доступных для пополнения"
                        item-text="name"
                        item-value="id"
                        outlined
                    >
                        <!-- Шаблон стейта при осущестеленно выборе -->
                        <template slot="selection" slot-scope="data">
                            <span v-if="data.item.id == null">
                                Нет доступных кошельков
                            </span>
                            <span v-else>
                                {{ data.item.wallet == null ? 'Карта' : 'Кошелек' }}
                                ****{{ data.item.iban?.slice(-4) }} (остаток - {{ data.item.balance }} {{ data.item.currency?.code }})
                            </span>
                        </template>
                        <!-- Шаблон стейта выбора -->
                        <template slot="item" slot-scope="data">
                            <span v-if="data.item.id == null">
                                Нет доступных кошельков
                            </span>
                            <span v-else>
                                {{ data.item.wallet == null ? 'Карта' : 'Кошелек' }}
                                ****{{ data.item.iban?.slice(-4) }} (остаток - {{ data.item.balance }} {{ data.item.currency?.code }})
                            </span>
                        </template>
                    </v-select>
                </v-col>
                <v-col>
                    <v-text-field
                        type="number"
                        v-model="form.amount"
                        :suffix="'RUB'"
                        label="Сумма"
                        persistent-hint
                        hide-spin-buttons
                        outlined
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-card-text>

        <v-divider></v-divider>
        <v-card-actions>
            <v-spacer />
            <v-btn
                color="primary"
                nuxt
                @click="create"
                :loading="LOADING_STATUS"
            >
                Пополнить счет
            </v-btn>
        </v-card-actions>
    </v-card>
</template>


<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {
    computed: {
        ...mapGetters({
            ACCOUNT_SELECT_LIST: "payment/ACCOUNT_SELECT_LIST",
            CURRENCIES_SELECT_LIST: "currency/CURRENCIES_SELECT_LIST",
            LOADING_STATUS: "wallet/LOADING_STATUS",
        }),
    },
    methods: {
        ...mapActions({
            topupAccount: "payment/topupAccount"
        }),

        async create(){
            await this.topupAccount(this.form);
            // await this.getMyCards();
            // this.dialog = false;
        }
    },
    data () {
        return {
            valid: false,
            dialog: false,
            form: {
                accountId: null,
                amount: null,
            },
        }
    },
}
</script>
