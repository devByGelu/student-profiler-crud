import {
    AlertDialog,
    AlertDialogOverlay,
    AlertDialogContent,
    AlertDialogHeader,
    AlertDialogCloseButton,
    AlertDialogBody,
    AlertDialogFooter,
    Button,
    requiredChakraThemeKeys,
    Input,
    FormErrorMessage,
    FormControl,
    FormLabel,
    Radio,
} from "@chakra-ui/react";
import React from "react";
import { useAppDispatch, useAppSelector } from "../app/hooks";
import {
    select,
    selectStudent,
    IStudent,
    selectMode,
    setMode,
} from "../student/studentSlice";
import { Form, Field } from "react-final-form";
import { AdaptedRadioGroup, InputControl } from "./final-form-helpers";
import axios, { AxiosResponse } from "axios";
import _ from "lodash";
import { APP_URL } from "../constants";

export default function SelectedStudenFormDialog({
    handleSuccess,
}: {
    handleSuccess: () => void;
}) {
    const dispatch = useAppDispatch();
    const student = useAppSelector(selectStudent);
    const mode = useAppSelector(selectMode);
    const handleClose = () => {
        dispatch(select({ student: null, mode: "update" }));
        dispatch(setMode("update"));
    };
    const cancelRef = React.useRef();
    const handleSubmit = async (values: IStudent) => {
        try {
            if (mode === "update") {
                const res: AxiosResponse = await axios.patch(
                    `${APP_URL}/api/students/${student.id}`,
                    {
                        firstName: values.firstName,
                        middleName: values.middleName,
                        lastName: values.lastName,
                        idNumber: values.idNumber,
                        slmisNumber: values.slmisNumber,
                        birthday: values.birthday,
                        sex: values.sex,
                    }
                );
                console.log(res.data);
            } else {
                const res: AxiosResponse = await axios.post(
                    `${APP_URL}/api/students`,
                    {
                        firstName: values.firstName,
                        middleName: values.middleName,
                        lastName: values.lastName,
                        idNumber: values.idNumber,
                        slmisNumber: values.slmisNumber,
                        birthday: values.birthday,
                        sex: values.sex,
                    }
                );
                console.log(res.data);
            }
            handleClose();
            handleSuccess();
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors: { [key: string]: string[] } =
                    error.response.data.errors;
                return _.mapValues(errors, (e) => e[0]);
            }
        }
    };

    return (
        <>
            <AlertDialog
                motionPreset="slideInBottom"
                onClose={handleClose}
                isOpen={student !== null || mode === "create"}
                isCentered
                leastDestructiveRef={cancelRef}
            >
                <AlertDialogOverlay />

                <AlertDialogContent>
                    <AlertDialogHeader>Select Student</AlertDialogHeader>
                    <AlertDialogCloseButton />
                    <AlertDialogBody>
                        <Form
                            initialValues={{
                                ...student,
                                sex: student ? student.sex : "Male",
                            }}
                            validateOnChange={false}
                            validateOnBlur={false}
                            subscription={{
                                submitError: true,
                                submitErrors: true,
                            }}
                            onSubmit={handleSubmit}
                            render={({ handleSubmit, submitting }) => {
                                return (
                                    <form onSubmit={handleSubmit}>
                                        {[
                                            { n: "idNumber", l: "ID Number" },
                                            {
                                                n: "slmisNumber",
                                                l: "SLMIS Number",
                                            },
                                            { n: "firstName", l: "First Name" },
                                            {
                                                n: "middleName",
                                                l: "Middle Name",
                                            },
                                            { n: "lastName", l: "Last Name" },
                                            { n: "birthday", l: "Birthday " },
                                            { n: "sex", l: "Sex" },
                                        ].map(({ n, l }) => {
                                            return n !== "sex" ? (
                                                <InputControl
                                                    key={n}
                                                    name={n}
                                                    label={l}
                                                    {...{
                                                        type:
                                                            n === "birthday"
                                                                ? "date"
                                                                : "text",
                                                        disabled: submitting
                                                            ? true
                                                            : false,
                                                    }}
                                                />
                                            ) : (
                                                <Field
                                                    name="sex"
                                                    component={
                                                        AdaptedRadioGroup
                                                    }
                                                    label="Sex"
                                                >
                                                    <Radio value="Male">
                                                        Male
                                                    </Radio>
                                                    <Radio
                                                        style={{
                                                            marginLeft: 10,
                                                        }}
                                                        value="Female"
                                                    >
                                                        Female
                                                    </Radio>
                                                </Field>
                                            );
                                        })}
                                        <AlertDialogFooter>
                                            <Button
                                                backgroundColor="blue.800"
                                                color="white"
                                                onClick={handleClose}
                                                ref={cancelRef}
                                            >
                                                Cancel
                                            </Button>
                                            <Button
                                                ml={3}
                                                variant="outline"
                                                colorScheme="gray"
                                                color="blue.800"
                                                type="submit"
                                                disabled={submitting}
                                            >
                                                {mode === "update"
                                                    ? "Update"
                                                    : "Create"}
                                            </Button>
                                        </AlertDialogFooter>
                                    </form>
                                );
                            }}
                        />
                    </AlertDialogBody>
                </AlertDialogContent>
            </AlertDialog>
        </>
    );
}
