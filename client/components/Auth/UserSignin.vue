<template>
    <v-card>
        <v-form v-model="valid" class="pa-6">
            <v-row>
                <v-col>
                <v-text-field
                    v-model="login.email"
                    :rules="nameRules"
                    label="Логин"
                    outlined
                    required
                ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                <v-text-field
                    v-model="login.password"
                    :rules="nameRules"
                    type="password"
                    label="Пароль"
                    outlined
                    required
                ></v-text-field>
                </v-col>
            </v-row>
            <v-btn
                color="primary"
                block
                @click="userLogin()"
            >
                Войти
            </v-btn>
        </v-form>
    </v-card>
</template>

<script>
  export default {
    data: () => ({
      valid: false,
      login: {
        email: '',
        password: ''
      },
      nameRules: [
        value => {
          if (value) return true
          return 'Обязательно для заполнения.'
        },
      ],
    }),
    methods: {
      async userLogin() {
        try {
          let response = await this.$auth.loginWith('local', { data: this.login })
          this.$router.push("/");
          console.log(response)
        } catch (err) {
          console.log(err)
        }
      }
    }
  }
</script>

