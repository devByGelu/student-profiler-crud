import axios, { AxiosResponse } from "axios";
import DataTable from "react-data-table-component";
import Head from "next/head";

import { GetStaticProps } from "next";
import Router from "next/router";
import React from "react";
import { useRouter } from "next/router";
import { motion } from "framer-motion";
import { Button, Divider, useAccordionContext } from "@chakra-ui/react";

export default function Home() {
    interface Student {
        idNnumber: number;
        fName: string;
        lName: string;
        mName: string;
        birthday: string;
        sex: string;
        slmisNumber: number;
    }
    interface User {
        created_at: string;
        email: string;
        email_verified_at: null;
        id: number;
        name: string;
        updated_at: string;
    }
    const router = useRouter();
    const [user, setUser] = React.useState<null | User>(null);
    const [students, setStudents] = React.useState<Student[]>([]);
    const handleClickLogout = async () => {
        try {
            await axios.post("http://localhost:8000/logout");
            router.push("/login");
        } catch (error) {
            console.log(error.toJSON());
        }
    };

    const getUser = async () => {
        const api_url = "http://localhost:8000";
        const user_object_route = "api/user";
        try {
            let response: AxiosResponse = await axios.get(
                `${api_url}/${user_object_route}`
            );
            console.log(response.data);
            setUser(response.data);
        } catch (error) {
            console.log(error.toJSON());
        }
    };

    const getStudents = async () => {
        const api_url = "http://localhost:8000";
        const user_object_route = "api/students";
        try {
            let response: AxiosResponse = await axios.get(
                `${api_url}/${user_object_route}`
            );
            console.log(response.data);
            setStudents(response.data);
        } catch (error) {
            console.log(error.toJSON());
        }
    };

    React.useEffect(() => {
        if (!user) getUser();
        if (!students.length) getStudents();
    }, [user, user?.id]);
    const LogoutBtn = () => {
        return (
            <Button
                variant="ghost"
                size="sm"
                onClick={handleClickLogout}
                rightIcon={
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        className="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                        />
                    </svg>
                }
            >
                Log out
            </Button>
        );
    };

    return (
        <motion.div
            className="flex flex-col items-center justify-center min-h-screen max-w-3xl mx-auto"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ delay: 0.5 }}
            exit={{ opacity: 0 }}
        >
            <Head>
                <title>Student Profiler</title>
                <link rel="icon" href="/favicon.ico" />
            </Head>
            <div className="flex flex-col w-full px-5 border-gray-200">
                <div className="text-2xl sm:text-3xl flex container flex-col sm:flex-row sm:items-center ">
                    <div className="ml-auto mb-5 sm:hidden">
                        <LogoutBtn />
                    </div>

                    <div>
                        <span className="text-gray-500">Hello, </span>
                        {" " + user?.email}
                    </div>
                    <div className="ml-auto hidden sm:block">
                        <LogoutBtn />
                    </div>
                </div>
                <Divider className="mb-10 mt-5" />
                <div className="text-2xl font-bold text-primary">Students</div>

                <Divider className="mb-10 mt-5" width={300} />
                <DataTable
                    noHeader
                    highlightOnHover
                    pointerOnHover
                    data={students}
                    columns={[
                        { name: "ID Number", selector: "idNumber" },
                        { name: "SLMIS Number", selector: "slmisNumber" },
                        { name: "First Name", selector: "fName" },
                        { name: "Middle Name", selector: "mName" },
                        { name: "Last Name", selector: "lName" },
                        { name: "Birthday", selector: "birthday" },
                        { name: "Sex", selector: "sex" },
                    ]}
                />
            </div>
        </motion.div>
    );
}