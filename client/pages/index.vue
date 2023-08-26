<template>
  <v-row justify="center" align="center">
  </v-row>
</template>


<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {
  middleware: ['auth', 'away'],
  layout: 'user',
};
</script>

