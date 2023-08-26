<template>
    <v-row justify="center" align="center">
        <v-col cols="12" sm="12" md="12">
            <div v-if="!PRELOADER_STATUS">
                <HistoryBoard />
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
        PRELOADER_STATUS: "history/PRELOADER_STATUS",
    }),

    methods: {
        ...mapActions({
            getMyHistory: "history/getMyHistory",
        }),
        ...mapMutations({
            activatePreloader: 'history/activatePreloader',
            deactivatePreloader: 'history/deactivatePreloader'
        }),
    },

    async fetch() {
        await this.activatePreloader();
        await this.getMyHistory();
        await this.deactivatePreloader();
    }
};
</script>
