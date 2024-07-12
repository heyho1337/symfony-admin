/** @type {import('tailwindcss').Config} */

import withMT from "@material-tailwind/html/utils/withMT";

module.exports = withMT({
	content: [
		"./assets/**/*.js",
		"./assets/**/*.css",
		"./templates/**/*.twig",
	],
	theme: {
		extend: {},
	},
	plugins: [],
});