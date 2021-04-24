import { Button } from "@chakra-ui/react";
import axios from "axios";
import React from "react";

export default function SignInPage() {
    const handleClickSignIn = async (params) => {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie");
        //localhost:8000/login
        const res = await axios.post("http://localhost:8000/login", {
            email: "",
            password: "",
        });
        // console.log(res.data);
    };

    return (
        <div>
            <Button onClick={handleClickSignIn}>Sign in</Button>
        </div>
    );
}
