// import "../styles/globals.css";
import "tailwindcss/tailwind.css";
import { ChakraProvider } from "@chakra-ui/react";
import axios from "axios";
import { AnimateSharedLayout } from "framer-motion";

axios.defaults.withCredentials = true;
function MyApp({ Component, pageProps }) {
    return (
        <ChakraProvider>
            <AnimateSharedLayout>
                <Component {...pageProps} />
            </AnimateSharedLayout>
        </ChakraProvider>
    );
}

export default MyApp;
