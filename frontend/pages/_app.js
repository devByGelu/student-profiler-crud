// import "../styles/globals.css";
import "tailwindcss/tailwind.css";
import { ChakraProvider } from "@chakra-ui/react";
import axios from "axios";
import { AnimateSharedLayout } from "framer-motion";
import { Provider } from "react-redux";
import { store } from "../app/store.ts";

axios.defaults.withCredentials = true;
function MyApp({ Component, pageProps }) {
    return (
        <ChakraProvider>
            <AnimateSharedLayout>
                <Provider store={store}>
                    <Component {...pageProps} />
                </Provider>
            </AnimateSharedLayout>
        </ChakraProvider>
    );
}

export default MyApp;
