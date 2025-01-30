<script setup>
import { Button, InputText, Password } from "primevue";
import { reactive } from "vue";

const form = reactive({
    username: "",
    password: "",
});
</script>

<template>
    <div class="h-full flex flex-col justify-center gap-12 items-center">
        <h1 class="text-4xl">blaise</h1>
        <form class="flex flex-col gap-4 w-full sm:w-64">
            <InputText
                type="email"
                v-model="form.username"
                placeholder="Adresse email"
                required
            />
            <Password
                v-model="form.password"
                placeholder="Mot de passe"
                :feedback="false"
                fluid
                required
            />
            <Button
                type="submit"
                severity="secondary"
                label="Se connecter"
            ></Button>
        </form>
    </div>
</template>
