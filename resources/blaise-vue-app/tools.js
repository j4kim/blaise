import dayjs from "dayjs";

// credits: https://stackoverflow.com/a/56592365
export const pick = (obj, ...keys) =>
    Object.fromEntries(
        keys.filter((key) => key in obj).map((key) => [key, obj[key]])
    );

export function formatDate(isoDate, time = false) {
    const date = dayjs(isoDate);
    return date.isValid()
        ? date.format("DD.MM.YYYY" + (time ? " HH:mm" : ""))
        : isoDate;
}

export function confirmDelete(confirmService, message, accept) {
    return confirmService.require({
        message,
        header: "Suppression",
        icon: "pi pi-info-circle",
        rejectProps: {
            label: "Annuler",
            severity: "secondary",
        },
        acceptProps: {
            label: "Oui, supprimer",
            severity: "danger",
        },
        accept,
    });
}
