import { ref } from "vue";

export const csrfToken = ref(
    document.querySelector('meta[name="csrf-token"]').getAttribute("content")
);

export async function request(uri, options = {}) {
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
}

export const get = request;

export async function post(uri, data) {
    return await request(uri, { body: JSON.stringify(data), method: "POST" });
}
