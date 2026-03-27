import React, { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { App } from "./App";
import './i18n.js';

const containers = document.querySelectorAll(".ra_garantias");
containers.forEach((container) => {
    const root = createRoot(container);
    root.render(
        <StrictMode>
            <App />
        </StrictMode>);
});
