<template>
    <v-row justify="center" align="center">
        <v-col cols="12" sm="12" md="12">
            <div v-if="!PRELOADER_STATUS">
                <DashBoard />
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
        CARDS_LIST: "card/CARDS_LIST",
        PRELOADER_STATUS: "card/PRELOADER_STATUS",
    }),

    methods: {
        ...mapActions({
            getMyCards: "card/getMyCards",
            getAllCurrencies: "currency/getAllCurrencies",
            getAllBanks: "bank/getAllBanks",
        }),
        ...mapMutations({
            cardUpdate: "card/cardUpdate",
            activatePreloader: 'card/activatePreloader',
            deactivatePreloader: 'card/deactivatePreloader'
        }),
    },

    async fetch() {
        await this.activatePreloader();
        await this.getMyCards();
        await this.getAllCurrencies();
        await this.getAllBanks();
        await this.deactivatePreloader();
    }
};
</script>
