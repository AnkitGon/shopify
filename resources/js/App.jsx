
import React from 'react';
import createRoot from 'react-dom';
import { AppProvider, Frame } from "@shopify/polaris";
import '@shopify/polaris/build/esm/styles.css';
import { BrowserRouter } from 'react-router-dom';
import Tabs from './components/layouts/Tabs';
import RoutePath from './components/routes/RoutePath';

export default function App() {

    return (
        <AppProvider theme={{ colorScheme: "light" }}>
            <Frame>
                <Tabs />
                <RoutePath />
            </Frame>
        </AppProvider>
    );
}

if (document.getElementById('app')) {

    createRoot.render(
        <BrowserRouter>
            <App />
        </BrowserRouter>

        ,
        document.getElementById("app"));
}
