<template>
  <v-row>
    <v-col cols="12" sm="12" md="12">
        <v-card>
            <v-toolbar flat>
                <v-toolbar-title>
                    История транзакций
                </v-toolbar-title>
            </v-toolbar>

            <v-data-table
                no-data-text="История транзакций еще пуста!"
                no-results-text="Поиск не дал результатов"
                :footer-props="{'items-per-page-text': 'Строк в таблице'}"
                :headers="headers"
                :items="HISTORY_LIST"
            >
                <template v-slot:item.account_payer="{ item }">
                    <span>
                        {{ item.payer.user.surname }}
                        {{ item.payer.user.name }}
                        ({{ item.payer.iban }})
                    </span>
                </template>

                <template v-slot:item.account_payee="{ item }">
                    <span>
                        {{ item.payee.user.surname }}
                        {{ item.payee.user.name }}
                        ({{ item.payee.iban }})
                    </span>
                </template>

                <template v-slot:item.amount_payer="{ item }">
                    <span>{{ item.amount_payer }} {{ item.currency_payer }}</span>
                </template>

                <template v-slot:item.amount_payee="{ item }">
                    <span>{{ item.amount_payee }} {{ item.currency_payee }}</span>
                </template>

                <template v-slot:item.created_at="{ item }">
                    {{ $moment(item.created_at).format("Do MMMM, HH:MM") }}
                </template>
            </v-data-table>
        </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {

    computed: mapGetters({
        HISTORY_LIST: "history/HISTORY_LIST",
    }),

    data () {
        return {
            headers: [
                {
                    text: 'Отправитель',
                    align: 'start',
                    sortable: false,
                    value: 'account_payer',
                },
                {
                    text: 'Получатель',
                    align: 'start',
                    sortable: false,
                    value: 'account_payee',
                },
                {
                    text: 'Отправленно',
                    align: 'start',
                    sortable: false,
                    value: 'amount_payer',
                },
                {
                    text: 'Получено',
                    align: 'start',
                    sortable: false,
                    value: 'amount_payee',
                },
                {
                    text: 'Дата',
                    align: 'start',
                    sortable: false,
                    value: 'created_at',
                },
            ],
    }
    }
}
</script>
