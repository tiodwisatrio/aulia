import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./app/Modules/**/*.blade.php",
    ],

    safelist: [
        "bg-blue-800",
        "bg-blue-700",
        "bg-blue-600",
        // Tambahkan classes lain yang mungkin di-generate dinamically
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                crimson: ["Crimson Text", "Georgia", "serif"],
            },
            colors: {
                "brand-bg": "#FFF0DA",
                "brand-text": "#893800",
            },
        },
    },

    plugins: [forms],
};
