<script setup>
import { Button, InputText, Password } from "primevue";
import { reactive } from "vue";
import { csrfToken, post } from "../api";

const form = reactive({
    email: "",
    password: "",
});

async function submit() {
    const { data, response } = await post("/api/authenticate", form);
    if (response.ok) {
        csrfToken.value = data.new_token;
    }
}
</script>

<template>
    <div class="h-full flex flex-col justify-center gap-12 items-center">
        <h1 class="text-4xl">blaise</h1>
        <form
            class="flex flex-col gap-4 w-full sm:w-64"
            @submit.prevent="submit"
        >
            <InputText
                type="email"
                v-model="form.email"
                placeholder="Adresse email"
                required
            />
            <Password
                v-model="form.password"
                placeholder="Mot de passe"
                :feedback="false"
                fluid
                required
                toggleMask
            />
            <Button
                type="submit"
                severity="secondary"
                label="Se connecter"
            ></Button>
        </form>
    </div>
</template>
