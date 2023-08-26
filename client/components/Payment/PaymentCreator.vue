<template>
    <v-card>
        <v-toolbar flat>
            <v-toolbar-title>
                Отправка перевода
            </v-toolbar-title>
        </v-toolbar>
        <v-card-text>
            <v-form v-model="valid">
                <v-row>
                    <v-col>
                        <v-select
                            v-model="ui.outgoing"
                            :rules="accountPayerRule"
                            :items="ACCOUNT_SELECT_LIST"
                            label="Кошелек (карта) отправителя"
                            no-data-text="Нет доступных для выбора кошельков / карт"
                            item-text="name"
                            item-value="id"
                            outlined
                            return-object
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
                        <v-select
                            v-model="ui.incoming"
                            :items="ACCOUNT_SELECT_LIST"
                            :rules="accountPayeeRule"
                            label="Кошелек (карта) отправителя"
                            no-data-text="Нет доступных для выбора кошельков / карт"
                            item-text="name"
                            item-value="id"
                            outlined
                            return-object
                        >
                            <!-- Шаблон стейта при осущестеленно выборе -->
                            <template slot="selection" slot-scope="data">
                                <span v-if="data.item.id == null">
                                    Нет доступных кошельков
                                </span>
                                <span v-else>
                                    {{ data.item.wallet == null ? 'Карта' : 'Кошелек' }}
                                    ****{{ data.item.iban?.slice(-4) }} (остаток - {{  data.item.balance }} {{ data.item.currency?.code }})
                                </span>
                            </template>
                            <!-- Шаблон стейта выбора -->
                            <template slot="item" slot-scope="data">
                                <span v-if="data.item.id == null">
                                    Нет доступных кошельков
                                </span>
                                <span v-else>
                                    {{ data.item.wallet == null ? 'Карта' : 'Кошелек' }}
                                    ****{{ data.item.iban?.slice(-4) }} (остаток - {{  data.item.balance }} {{ data.item.currency?.code }})
                                </span>
                            </template>
                        </v-select>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            v-model="form.amount"
                            :rules="enoughRule"
                            :suffix="ui.outgoing?.currency?.code"
                            type="number"
                            label="Сумма получателя"
                            persistent-hint
                            hide-spin-buttons
                            outlined
                        ></v-text-field>
                    </v-col>
                    <v-col>
                        <v-alert
                            v-if="(ui.outgoing?.currency?.code != ui.incoming?.currency?.code) &&
                                  (ui.outgoing?.currency?.code != null && ui.incoming?.currency?.code != null)"
                            color="blue"
                            type="info"
                        >
                            Курс конвертации {{ (1/GET_RATE(ui.outgoing?.currency?.code)).toFixed(2) || '—' }} руб.
                        </v-alert>
                    </v-col>
                </v-row>
                <small>Нажимая кнопку «Отправить перевод», вы автоматически соглашаетесь с условями оферы, а также подтверждаете ознакомление с вашим текущим тарифным планом. В некоторых случаях, при осуществлении транзакции дополнительно может сниматься комиссия.</small>
            </v-form>
        </v-card-text>

        <v-divider></v-divider>
        <v-card-actions>
            <v-spacer />
            <v-btn
                color="primary"
                nuxt
                :disabled="!valid"
                @click="create"
                :loading="LOADING_STATUS"
            >
                Отправить перевод
            </v-btn>
        </v-card-actions>
    </v-card>
</template>


<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {
    computed: {
        ...mapGetters({
            GET_RATE: "currency/GET_RATE",
            ACCOUNT_SELECT_LIST: "payment/ACCOUNT_SELECT_LIST",
            CURRENCIES_SELECT_LIST: "currency/CURRENCIES_SELECT_LIST",
            BANKS_SELECT_LIST: "bank/BANKS_SELECT_LIST",
            LOADING_STATUS: "wallet/LOADING_STATUS",
        }),
    },
    methods: {
        ...mapActions({
            getMyCards: "card/getMyCards",
            createCard: "card/createCard",
            createTransaction: "card/createTransaction"
        }),

        async create(){
            await this.createTransaction({
                accountPayer: this.ui.outgoing?.id,
                accountPayee: this.ui.incoming?.id,
                amount: this.form.amount
            });

            // this.$router.push({ path: `/user/history` });
            // await this.getMyCards();
            // this.dialog = false;
        }
    },
    data () {
        return {
            valid: false,
            dialog: false,
            form: {
                currencyId: null,
                amount: null,
            },
            ui: {
                outgoing: {},
                incoming: {}
            },

            // Валидаторы
            enoughRule: [
                value => {
                    if (value) return true
                    return 'Обязательно для заполнения.'
                },
                value => {
                    if (value <= this.ui.outgoing?.balance) return true
                    return 'Недостаточно средств для перевода'
                },
            ],

            accountPayerRule: [
                value => {
                    if (value) return true
                    return 'Обязательно для заполнения.'
                },
            ],

            accountPayeeRule: [
                value => {
                    if (value) return true
                    return 'Обязательно для заполнения.'
                },
                // Если первод между воллетом и картой, должна быть одна страна
                value => {
                    if (
                        (this.ui.outgoing?.wallet != null && this.ui.incoming?.wallet != null) ||
                        (this.ui.outgoing?.currency?.code == this.ui.incoming?.currency?.code)
                    ) return true
                    return 'Оплата вне юрисдикции текущего счета.'
                },
            ],
        }
    },
}
</script>
