<template>
    <v-row justify="center" align="center">
        <v-col cols="12" sm="10" md="10">
            <div v-if="!PRELOADER_STATUS">
                <BankEditor />
            </div>
            <v-skeleton-loader v-else type="table"></v-skeleton-loader>
        </v-col>
    </v-row>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {
    middleware: 'auth',
    layout: 'user',

    computed: mapGetters({
        PRELOADER_STATUS: "bank/PRELOADER_STATUS",
    }),

    methods: {
        ...mapActions({
            getBank: "bank/getBank",
        }),
        ...mapMutations({
            activatePreloader: 'bank/activatePreloader',
            deactivatePreloader: 'bank/deactivatePreloader'
        }),
    },

    async fetch() {
        await this.activatePreloader();
        await this.getBank(this.$route.params.id);
        await this.deactivatePreloader();
    }
};
</script>
