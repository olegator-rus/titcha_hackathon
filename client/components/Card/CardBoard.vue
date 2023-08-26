<template>
    <v-row>
        <v-col cols="12" sm="12" md="12">
            <v-card>
                <v-toolbar flat>
                    <v-toolbar-title>
                        Мои цифровые кошельки
                    </v-toolbar-title>

                    <v-spacer></v-spacer>

                    <CardCreator/>
                </v-toolbar>

                <v-divider></v-divider>

                <v-list two-line>
                    <v-carousel v-if="CARDS_COUNT > 0"
                        cycle
                        height="450"
                        hide-delimiter-background
                        show-arrows="hover"
                        delimiter-icon="mdi-circle-small"
                    >
                        <v-carousel-item
                            class="mt-5"
                            v-for="card in CARDS_FORMATTED_LIST"
                            :key="card.number"
                        >
                            <v-row>
                                <v-col>
                                    <vue-paycard
                                        :is-card-number-masked="false"
                                        :value-fields="card"
                                    />
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col align="center">
                                    <div>{{ card.cardIban }}</div>
                                    <div>Доступно: {{ card.cardAmount }} {{ card.cardCurrency }}</div>
                                </v-col>
                            </v-row>
                        </v-carousel-item>
                    </v-carousel>


                    <v-col v-if="!CARDS_COUNT" align="center" justify="center">
                        <v-img
                            :src="require('../../assets/illustrations/png/event.png')"
                            class="mb-5"
                            width="600px"
                        ></v-img>
                        <h3>Карты пока отсутствуют.</h3>
                    </v-col>
                </v-list>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from "vuex";

export default {
    computed: {
        ...mapGetters({
            CARD: "card/CARD",
            CARDS_FORMATTED_LIST: "card/CARDS_FORMATTED_LIST",
            CARDS_COUNT: "card/CARDS_COUNT",
            CARDS_LIST: "card/CARDS_LIST",
            LOADING_STATUS: "card/LOADING_STATUS",
        }),
    },
    methods: {
        ...mapActions({
            getMyCards: "card/getMyCards",
        })
    },
}
</script>
