<template>
    <v-app>
        <v-main>
            <v-container>
                <v-row justify="center" align="center">
                    <v-col cols="12" sm="4" md="4">
                        <UserSignin />
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    middleware: ['guest'],
    layout: 'auth',
}
</script>
