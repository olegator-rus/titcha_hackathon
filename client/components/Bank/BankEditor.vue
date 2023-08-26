<template>
    <v-card :loading="LOADING_STATUS">
     <v-card-title class="headline">
       Редактор мероприятия
     </v-card-title>
     <v-divider class="mb-6"></v-divider>
     <v-card-text>
       <v-form v-model="valid">
         <v-row>
           <v-col>
             <v-text-field
               v-model="form.name"
               label="Название банка"
               outlined
               required
             ></v-text-field>
           </v-col>
         </v-row>
         <v-row>
           <v-col>
             <v-text-field
               v-model="form.country"
               :counter="300"
               label="Страна банка"
               rows="3"
               no-resize
               outlined
             ></v-text-field>
           </v-col>
         </v-row>
         <v-row>
           <v-col>
             <v-text-field
               v-model="form.address"
               label="Адрес банка"
               outlined
               required
             ></v-text-field>
           </v-col>
         </v-row>
         <v-row>
           <v-col>
             <v-text-field
               v-model="form.swift_code"
               label="SWIFT-код банка"
               outlined
               required
             ></v-text-field>
           </v-col>
           <v-col>
             <v-text-field
               v-model="form.iban"
               label="IBAN-код банка"
               outlined
               required
             ></v-text-field>
           </v-col>
         </v-row>
       </v-form>
     </v-card-text>
     <v-divider></v-divider>
     <v-card-actions>
       <v-spacer />
       <v-btn
         color="primary"
         nuxt
         :loading="LOADING_STATUS"
         @click="save"
       >
         Сохранить
       </v-btn>
     </v-card-actions>
   </v-card>
 </template>

 <script>
   import { mapGetters, mapActions, mapMutations } from "vuex";

   export default {
        computed: mapGetters({
            BANK: "bank/BANK",
            LOADING_STATUS: "bank/LOADING_STATUS",
        }),
        methods: {
            ...mapActions({
                updateBank: "bank/updateBank",
            }),
            // Обходим все свойства объекта bank
            // и загружаем туда одноименные значения из VUEX
            recollectData(){
                Object.keys(this.form).forEach((key, value) => {
                    this.form[key] = this.BANK[key];
                });
            },
            // Метод обновления данных
            async save(){
                await this.updateBank(this.form);
            },
        },
        mounted() {
            // При инициализации пересобираем данные.
            this.recollectData();
        },
        data: () => ({
        valid: false,
        form: {
            id: null,
            name: null,
            country: null,
            address: null,
            swift_code: null,
            iban: null,
            TIN: null,
            is_central: null,
            currency_id: null,
        },
        }),
   }
 </script>
