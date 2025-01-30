export async function get(uri) {
    const response = await fetch(uri, {
        headers: { Accept: "application/json" },
    });
    const data = await response.json();
    return data;
}
