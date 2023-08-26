<template>
  <v-row>
    <v-col cols="12" sm="12" md="12">
      <v-card >
        <v-toolbar flat>
            <v-toolbar-title>
                Мои цифровые кошельки
            </v-toolbar-title>

            <v-spacer></v-spacer>

            <WalletCreator/>
        </v-toolbar>

        <v-divider></v-divider>

        <v-list two-line>
            <v-list-item-group
                v-model="selected"
                active-class="pink--text"
                multiple
            >
                <template v-for="(wallet, index) in WALLETS_LIST">
                    <v-list-item :key="wallet.id">
                        <template v-slot:default="{ active }">
                        <v-list-item-content>
                            <v-list-item-title>
                                Регион: {{ wallet.account.bank.name }}
                            </v-list-item-title>
                            <v-list-item-subtitle class="text--primary">
                                Счет: {{ wallet.account.iban }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-action>
                            <v-list-item-action-text>Остаток: {{ wallet.account.balance }} {{ wallet.account.currency.code }}</v-list-item-action-text>
                        </v-list-item-action>
                        </template>
                    </v-list-item>
                    <v-divider
                        v-if="index < WALLETS_COUNT - 1"
                        :key="index"
                    ></v-divider>
                </template>
            </v-list-item-group>
        </v-list>

        <v-col v-if="!WALLETS_COUNT" align="center" justify="center">
            <v-img
                :src="require('../../assets/illustrations/png/event.png')"
                class="mt-7 mb-7"
                width="600px"
            ></v-img>
            <h3>Кошельки пока отсутствуют.</h3>
        </v-col>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {
    computed: mapGetters({
        WALLETS_COUNT: "wallet/WALLETS_COUNT",
        WALLETS_LIST: "wallet/WALLETS_LIST",
        LOADING_STATUS: "wallet/LOADING_STATUS",
    }),
    methods: {
        ...mapActions({
            getMyWallets: "wallet/getMyWallets",
        }),
    }
}
</script>
