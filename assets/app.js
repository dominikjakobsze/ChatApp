/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import Main from "./Main";

console.log('Hello Webpack Encore! Edit me in assets/app.js');
import React from "react";
import ReactDOM from "react-dom/client";

ReactDOM.createRoot(document.getElementById('react-app')).render(<Main/>);