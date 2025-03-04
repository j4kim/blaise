import { ref } from "vue";
import router from "./router";

export const csrfToken = ref(document.body.dataset.csrf);

export async function request(uri, options = {}) {
    var response = null;
    try {
        response = await fetch(uri, {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken.value,
            },
            ...options,
        });
    } catch (error) {
        alert(error);
        return;
    }

    const data = await response.json();

    if (response.status === 401) {
        router.push("/login");
    } else if (response.status === 419) {
        if (confirm(`Session expriée. Recharger la page ?`)) {
            location.reload();
        }
    }

    return { data, response };
}

export async function get(uri, params = {}) {
    return await request(`${uri}?${new URLSearchParams(params)}`);
}

export async function post(uri, data) {
    return await request(uri, { body: JSON.stringify(data), method: "POST" });
}

export async function put(uri, data) {
    return await request(uri, { body: JSON.stringify(data), method: "PUT" });
}

export async function del(uri) {
    return await request(uri, { method: "DELETE" });
}
