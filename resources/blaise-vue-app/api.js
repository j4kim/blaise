export async function request(uri, options = {}) {
    const response = await fetch(uri, {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
        },
        ...options,
    });
    const data = await response.json();
    return data;
}

export const get = request;

export async function post(uri, data) {
    return await request(uri, { body: JSON.stringify(data), method: "POST" });
}
