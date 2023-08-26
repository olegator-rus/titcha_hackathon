<template>
  <v-footer
    absolute
    padless
  >
    <v-card flat tile width="100%">
      <v-divider></v-divider>
      <v-card-text class="text--white">
        <v-row>
          <v-col>
            <small>
              {{ new Date().getFullYear() }} © Команда «PLEXeT»
            </small>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-footer>
</template>


<script>
  import { mapGetters, mapActions, mapMutations } from "vuex";

  export default {
    computed: mapGetters({
      PROJECT: "project/PROJECT",
    }),
    methods: {
    }
  }
</script>
