<template>
    <v-row justify="center" align="center">
        <v-col cols="12" sm="12" md="12">
            <div v-if="!PRELOADER_STATUS">
                <WalletBoard />
            </div>
            <v-skeleton-loader v-else type="table"></v-skeleton-loader>
        </v-col>
    </v-row>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {
    middleware: ['auth'],
    layout: 'user',

    computed: mapGetters({
        PRELOADER_STATUS: "wallet/PRELOADER_STATUS",
    }),

    methods: {
        ...mapActions({
            getMyWallets: "wallet/getMyWallets",
            getAllBanks: "bank/getAllBanks",
            getAllCurrencies: "currency/getAllCurrencies",
        }),
        ...mapMutations({
            activatePreloader: 'wallet/activatePreloader',
            deactivatePreloader: 'wallet/deactivatePreloader'
        }),
    },

    async fetch() {
        await this.activatePreloader();
        await this.getMyWallets();
        await this.getAllCurrencies();
        await this.deactivatePreloader();
    }
};
</script>
