import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    safelist: [
        "bg-gray-500",
        "bg-gray-100",
        "bg-blue-500",
        "bg-blue-100",
        "bg-cyan-500",
        "bg-cyan-100",
        "bg-yellow-500",
        "bg-yellow-100",
        "bg-orange-500",
        "bg-orange-100",
        "bg-green-500",
        "bg-green-100",
        "bg-red-500",
        "bg-red-100",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
