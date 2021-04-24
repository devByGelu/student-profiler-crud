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
import axios from "axios";
import React from "react";
import _ from "lodash";
import { useRouter } from "next/router";
import Head from "next/head";
import { motion } from "framer-motion";

export default function SignInPage() {
    const router = useRouter();
    const [errors, setErrors] = React.useState<{ [key: string]: string[] }>({});
    const [email, setEmail] = React.useState<string>("");
    const [password, setPassword] = React.useState<string>("");

    const [checkingAuth, setCheckingAuth] = React.useState<boolean>(true);

    const handleEmailChange = (event) => {
        setErrors({ ...errors, email: null });
        setEmail(event.currentTarget.value);
    };
    const handlePasswordChange = (event) => {
        setErrors({ ...errors, password: null });
        setPassword(event.currentTarget.value);
    };

    const handleClickSignIn = async () => {
        try {
            await axios.get("http://localhost:8000/sanctum/csrf-cookie");
            await axios.post("http://localhost:8000/login", {
                email,
                password,
            });
            const api_url = "http://localhost:8000";
            const user_object_route = "api/user";
            await axios.get(`${api_url}/${user_object_route}`);
            router.push("/");
        } catch (error) {
            if (error.response) setErrors(error.response.data.errors);
        }
    };

    const checkAuthenticated = async () => {
        try {
            await axios.get("http://localhost:8000/api/user");
            router.push("/");
        } catch (error) {
            setCheckingAuth(false);
        }
    };

    React.useEffect(() => {
        checkAuthenticated();
    }, []);

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
                        <title>Login</title>
                        <link rel="icon" href="/favicon.ico" />
                    </Head>
                    <div className="font-bold text-4xl mb-10 text-primary">
                        Student Profiler
                    </div>
                    <Input
                        placeholder="Enter your email"
                        focusBorderColor="blue.800"
                        value={email}
                        isInvalid={errors?.email ? true : false}
                        onChange={handleEmailChange}
                    />
                    <Input
                        placeholder="Enter your password"
                        type="password"
                        focusBorderColor="blue.800"
                        value={password}
                        isInvalid={errors?.password ? true : false}
                        onChange={handlePasswordChange}
                    />

                    <Collapse
                        in={
                            !_.chain(errors).values().includes(null).value() &&
                            !_.isEmpty(errors)
                                ? true
                                : false
                        }
                        animateOpacity
                    >
                        <Box
                            p="10px"
                            color="white"
                            bg="red.200"
                            rounded="md"
                            borderColor="red.400"
                        >
                            <UnorderedList>
                                {_.values(errors).map((el) => {
                                    if (el)
                                        return el.map((errStr) => (
                                            <ListItem>{errStr}</ListItem>
                                        ));
                                })}
                            </UnorderedList>
                        </Box>
                    </Collapse>
                    <Button
                        style={{ width: "100%" }}
                        className="mt-5"
                        onClick={handleClickSignIn}
                        color="blue.800"
                    >
                        Sign in
                    </Button>
                    <div className="text-gray-500 mt-5 text-center">
                        Don't have an account?{" "}
                        <Link href="/signup">Sign up now</Link>
                    </div>
                </div>
            )}
        </motion.div>
    );
}
