<script setup>
import { Button, InputText, Message, Password } from "primevue";
import { reactive, ref } from "vue";
import { csrfToken, post } from "../api";
import { useRouter } from "vue-router";

const router = useRouter();

const form = reactive({
    email: "",
    password: "",
});

const error = ref("");

async function submit() {
    error.value = "";
    const { data, response } = await post("/api/authenticate", form);
    if (response.ok) {
        csrfToken.value = data.new_token;
        router.push("/");
    } else if (response.status === 422) {
        error.value = "Authentification échouée";
    } else {
        error.value = data.message ?? response.statusText;
    }
}
</script>

<template>
    <div class="sm:h-1/3"></div>
    <div class="flex flex-col justify-center gap-12 items-center">
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
            <Message v-if="error" severity="error" :life="3000">
                {{ error }}
            </Message>
        </form>
    </div>
</template>
