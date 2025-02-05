<script setup>
import { reactive, ref } from "vue";
import { get, put } from "../../api";
import { Button, Card, Message, Password } from "primevue";
import { csrfToken, post } from "../../api";
import { useRouter } from "vue-router";

const router = useRouter();

const user = ref({});

get("/api/user").then(({ data }) => (user.value = data));

async function logout() {
    const { data, response } = await post("/api/logout");
    if (response.ok) {
        csrfToken.value = data.new_token;
        router.push("/login");
    }
}

const pwdForm = reactive({
    password: "",
    newPassword: "",
    newPassword_confirmation: "",
});

const pwdRes = reactive({
    errors: {},
    success: false,
});

async function updatePassword() {
    pwdRes.errors = {};
    pwdRes.success = false;
    const { data, response } = await put("/api/update-password", pwdForm);
    if (!response.ok) {
        pwdRes.errors = data.errors;
    } else {
        pwdRes.success = true;
        pwdForm.password = "";
        pwdForm.newPassword = "";
        pwdForm.newPassword_confirmation = "";
    }
}
</script>

<template>
    <h2 class="text-3xl font-extralight mt-4">Profil</h2>

    <form @submit.prevent="logout" class="my-8">
        <Card>
            <template #title>Déconnexion</template>
            <template #content>
                <p class="my-8">
                    Vous êtes connecté·e en tant que {{ user.name }} (
                    {{ user.email }} )
                </p>
            </template>
            <template #footer>
                <div class="flex justify-end">
                    <Button type="submit" label="Se déconnecter"></Button>
                </div>
            </template>
        </Card>
    </form>

    <form @submit.prevent="updatePassword" class="my-8">
        <Card>
            <template #title>Changement de mot de passe</template>
            <template #content>
                <p class="my-4">
                    <label for="password">Mot de passe actuel</label>
                    <Password
                        v-model="pwdForm.password"
                        id="password"
                        :feedback="false"
                        :invalid="pwdRes.errors.password"
                        fluid
                        required
                        toggleMask
                    />
                    <Message
                        v-if="pwdRes.errors.password"
                        severity="error"
                        variant="simple"
                        size="small"
                    >
                        {{ pwdRes.errors.password.join() }}
                    </Message>
                </p>
                <p class="my-4">
                    <label for="newPassword"> Nouveau mot de passe </label>
                    <Password
                        v-model="pwdForm.newPassword"
                        id="newPassword"
                        :feedback="false"
                        :invalid="pwdRes.errors.newPassword"
                        fluid
                        required
                        toggleMask
                    />
                    <Message
                        v-if="pwdRes.errors.newPassword"
                        severity="error"
                        variant="simple"
                        size="small"
                    >
                        {{ pwdRes.errors.newPassword.join() }}
                    </Message>
                </p>
                <p class="my-4">
                    <label for="newPassword_confirmation">
                        Confirmation du nouveau mot de passe
                    </label>
                    <Password
                        v-model="pwdForm.newPassword_confirmation"
                        id="newPassword_confirmation"
                        :feedback="false"
                        :invalid="pwdRes.errors.newPassword_confirmation"
                        fluid
                        required
                        toggleMask
                    />
                    <Message
                        v-if="pwdRes.errors.newPassword_confirmation"
                        severity="error"
                        variant="simple"
                        size="small"
                    >
                        {{ pwdRes.errors.newPassword_confirmation.join() }}
                    </Message>
                </p>
            </template>
            <template #footer>
                <div class="flex justify-end flex-wrap gap-4">
                    <Message
                        v-if="pwdRes.success"
                        severity="success"
                        class="grow"
                        :life="3000"
                    >
                        Mot de passe modifié
                    </Message>
                    <Button type="submit" label="Modifier"></Button>
                </div>
            </template>
        </Card>
    </form>
</template>
