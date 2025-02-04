// credits: https://stackoverflow.com/a/56592365
export const pick = (obj, ...keys) =>
    Object.fromEntries(
        keys.filter((key) => key in obj).map((key) => [key, obj[key]])
    );
