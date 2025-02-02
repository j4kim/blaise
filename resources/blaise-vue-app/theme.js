import { definePreset } from "@primevue/themes";
import Aura from "@primevue/themes/aura";

export default {
    preset: definePreset(Aura, {
        semantic: {
            primary: {
                50: "{violet.50}",
                100: "{violet.100}",
                200: "{violet.200}",
                300: "{violet.300}",
                400: "{violet.400}",
                500: "{violet.500}",
                600: "{violet.600}",
                700: "{violet.700}",
                800: "{violet.800}",
                900: "{violet.900}",
                950: "{violet.950}",
            },
            colorScheme: {
                dark: {
                    surface: {
                        0: "#ffffff",
                        50: "{gray.50}",
                        100: "{gray.100}",
                        200: "{gray.200}",
                        300: "{gray.300}",
                        400: "{gray.400}",
                        500: "{gray.500}",
                        600: "{gray.600}",
                        700: "{gray.700}",
                        800: "{gray.800}",
                        900: "{gray.900}",
                        950: "{gray.950}",
                    },
                },
            },
        },
    }),
};
