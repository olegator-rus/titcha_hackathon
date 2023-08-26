<template>
    <v-row justify="center" align="top">
        <v-col cols="12" sm="12" md="4">
            <v-alert text color="primary">
                Уважаемый пользователь, на данной странице вы можете пополнить свой основной рублевый счет, для дальнейшего осуществления транзакций.
                <v-divider class="my-4 primary" style="opacity: 0.22"></v-divider>
                Обратите внимание, что данная форма является эмуляцией платежного шлюза.
            </v-alert>
        </v-col>
        <v-col cols="12" sm="12" md="8">
            <div v-if="!PRELOADER_STATUS">
                <PaymentTopup />
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
        }),
        ...mapMutations({
            activatePreloader: 'payment/activatePreloader',
            deactivatePreloader: 'payment/deactivatePreloader'
        }),
    },

    async fetch() {
        await this.activatePreloader();
        await this.getMyAccounts();
        await this.deactivatePreloader();
    }
};
</script>
