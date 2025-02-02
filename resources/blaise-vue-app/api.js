import { ref } from "vue";

export const csrfToken = ref(document.body.dataset.csrf);

export async function request(uri, options = {}) {
    try {
        const response = await fetch(uri, {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken.value,
            },
            ...options,
        });
        const data = await response.json();
        return { data, response };
    } catch (error) {
        alert(error);
    }
}

export const get = request;

export async function post(uri, data) {
    return await request(uri, { body: JSON.stringify(data), method: "POST" });
}

export async function del(uri) {
    return await request(uri, { method: "DELETE" });
}
