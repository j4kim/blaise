<script setup>
import { ref } from "vue";
import { get } from "../api";
import { Button } from "primevue";
import { reactive } from "vue";
import { csrfToken, post } from "../api";
import { useRouter } from "vue-router";

const router = useRouter();

const user = ref({});

get("/api/user").then(({ data }) => (user.value = data));

async function submit() {
    const { data, response } = await post("/api/logout");
    if (response.ok) {
        csrfToken.value = data.new_token;
        router.push("/login");
    }
}
</script>

<template>
    <form @submit.prevent="submit">
        <p>
            Vous êtes connecté·e en tant que {{ user.name }} (
            {{ user.email }} )
        </p>
        <Button
            type="submit"
            severity="secondary"
            label="Se déconnecter"
        ></Button>
    </form>
</template>
