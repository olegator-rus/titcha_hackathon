<template>
    <v-row justify="center" align="center">
        <v-col cols="12" sm="8" md="8">
            <div v-if="!PRELOADER_STATUS">
                <PaymentCreator />
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
        PRELOADER_STATUS: "payment/PRELOADER_STATUS",
    }),

    methods: {
        ...mapActions({
            getMyAccounts: "payment/getMyAccounts",
            getAllRates: "currency/getAllRates",
            getAllCurrencies: "currency/getAllCurrencies",
        }),
        ...mapMutations({
            activatePreloader: 'payment/activatePreloader',
            deactivatePreloader: 'payment/deactivatePreloader'
        }),
    },

    async fetch() {
        await this.activatePreloader();
        await this.getMyAccounts();
        await this.getAllRates();
        await this.deactivatePreloader();
    }
};
</script>
