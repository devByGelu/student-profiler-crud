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
import { select, selectStudent, IStudent } from "../student/studentSlice";
import { Form, Field } from "react-final-form";
import { AdaptedRadioGroup, InputControl } from "./final-form-helpers";
import axios, { AxiosResponse } from "axios";
import _ from "lodash";

export default function SelectedStudenFormDialog() {
    const dispatch = useAppDispatch();
    const student = useAppSelector(selectStudent);
    const handleClose = () => {
        dispatch(select(null));
    };
    const cancelRef = React.useRef();
    const handleSubmit = async (values: IStudent) => {
        try {
            const res: AxiosResponse = await axios.patch(
                `http://localhost:8000/api/students/${student.id}`,
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
            handleClose();
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
                isOpen={student !== null}
                isCentered
                leastDestructiveRef={cancelRef}
            >
                <AlertDialogOverlay />

                <AlertDialogContent>
                    <AlertDialogHeader>Select Student</AlertDialogHeader>
                    <AlertDialogCloseButton />
                    <AlertDialogBody>
                        <Form
                            initialValues={{ ...student }}
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
                                                    label="Favorite Color"
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
                                                Update
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
