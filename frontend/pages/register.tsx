import {
    AlertIcon,
    Box,
    Button,
    Collapse,
    Fade,
    Input,
    Link,
    ListItem,
    requiredChakraThemeKeys,
    UnorderedList,
    Heading,
    Spinner,
} from "@chakra-ui/react";
import axios, { AxiosResponse } from "axios";
import React from "react";
import _ from "lodash";
import { useRouter } from "next/router";
import Head from "next/head";
import { motion } from "framer-motion";
import { Form } from "react-final-form";
import { InputControl } from "../components/final-form-helpers";
import { APP_URL } from "../constants";

export default function RegisterPage() {
    const router = useRouter();

    const [checkingAuth, setCheckingAuth] = React.useState<boolean>(true);

    const checkAuthenticated = async () => {
        try {
            await axios.get(`${APP_URL}/api/user`);
            router.push("/");
            setCheckingAuth(false);
        } catch (error) {
            setCheckingAuth(false);
        }
    };

    React.useEffect(() => {
        checkAuthenticated();
    }, []);

    const handleSubmit = async (values) => {
        try {
            const res: AxiosResponse = await axios.post(`${APP_URL}/register`, {
                email: values.email,
                password: values.password,
                name: values.name,
                password_confirmation: values.password_confirmation,
            });

            await axios.post(`${APP_URL}/login`, {
                email: values.email,
                password: values.password,
            });
            router.push("/");
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors: { [key: string]: string[] } =
                    error.response.data.errors;
                return _.mapValues(errors, (e) => e[0]);
            }
        }
    };
    return (
        <motion.div
            className="flex flex-col items-center justify-center min-h-screen"
            layoutId="login"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ delay: 0.5 }}
            exit={{ opacity: 0 }}
        >
            {checkingAuth ? (
                <Spinner />
            ) : (
                <div className="max-w-xs flex flex-col items-center gap-2 bg-white">
                    <Head>
                        <title>Register</title>
                        <link rel="icon" href="/favicon.ico" />
                    </Head>
                    <div className="font-bold text-4xl text-primary">
                        Student Profiler
                    </div>
                    <div className="text-md mb-10 text-gray-400">
                        Registration
                    </div>
                    <Form
                        onSubmit={handleSubmit}
                        render={({ handleSubmit, submitting }) => {
                            return (
                                <form onSubmit={handleSubmit}>
                                    {[
                                        { n: "name", l: "Name" },
                                        { n: "email", l: "Email" },
                                        { n: "password", l: "Password" },
                                        {
                                            n: "password_confirmation",
                                            l: "Confirm Password",
                                        },
                                    ].map(({ n, l }) => {
                                        return (
                                            <InputControl
                                                key={n}
                                                name={n}
                                                label={l}
                                                {...{
                                                    disabled: submitting
                                                        ? true
                                                        : false,
                                                    type: n.includes("password")
                                                        ? "password"
                                                        : "text",
                                                }}
                                            />
                                        );
                                    })}
                                    <Button
                                        style={{ width: "100%" }}
                                        className="mt-5"
                                        color="blue.800"
                                        type="submit"
                                    >
                                        Register
                                    </Button>
                                </form>
                            );
                        }}
                    />

                    <div className="text-gray-500 mt-5 text-center">
                        Already have an account?{" "}
                        <Link href="/login">Login</Link>
                    </div>
                </div>
            )}
        </motion.div>
    );
}
