<template>
    <v-row>
        <v-col>
            <v-card>

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
