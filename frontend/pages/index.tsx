import axios from "axios";
import Head from "next/head";
import styles from "../styles/Home.module.css";
import { GetStaticProps } from "next";
import Router from "next/router";
import React from "react";

export default function Home() {
    const handleClickLogout = async () => {
        try {
            await axios.post("http://localhost:8000/logout");
        } catch (error) {
            console.log(error.toJSON());
        }
    };

    const name = async () => {
        const api_url = "http://localhost:8000";
        const user_object_route = "api/user";
        try {
            await axios.get("http://localhost:8000/sanctum/csrf-cookie");
            let response = await axios.get(`${api_url}/${user_object_route}`);
            console.log(response);
        } catch (error) {
            console.log(error.toJSON());
            return {
                props: { test: error.reponse.data },
            };
        }
    };
    React.useEffect(() => {
        name();
    }, []);

    return (
        <div className={styles.container}>
            <Head>
                <title>Student Profiler</title>
                <link rel="icon" href="/favicon.ico" />
            </Head>
            <div onClick={handleClickLogout}>Logout</div>
        </div>
    );
}
